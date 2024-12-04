<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\ProfileUpdateRequest;
use Intervention\Image\Laravel\Facades\Image;

class ProfileController extends Controller
{


    public function index()
    {
        // $semua_satuan = Satuan::all();
        $title = 'Profile';
        $id = Auth::user()->id;
        $user = User::find($id);

        return view('backend.profile.index', compact('title', 'user'));
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update_backup(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function update(Request $request)
    {
        // Get the id of the authenticated user
        $id = Auth::user()->id;
        $user = User::find($id);

        // Validate the request data
        $validator = Validator::make($request->all(), [
            'name' => 'required', // User name is required
            'username' => 'required|unique:users,username,' . $id, // User name is required and unique
            'email' => 'nullable|email|unique:users,email,' . $id, // Email is optional, unique, and must be a valid email format
        ]);

        // If validation fails, return error response
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->toArray()
            ]);
        }

        // Save the required data from the request
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;

        // Save the nullable data from the request if it is not empty
        if ($request->email != null) {
            $user->email = $request->email;
        } else {
            $user->email = null;
        }

        // If the user profile is successfully updated, return success response
        if ($user->save()) {
            return response()->json([
                'status' => 'success',
                'message' => 'User Profile updated Successfully!'
            ]);
        } else {
            // If the user profile update fails, return error response
            return response()->json([
                'status' => 'error2',
                'message' => 'User Profile update Failed!'
            ]);
        }
    }

    public function updatePassword(Request $request)
    {
        // Get the id of the authenticated user
        $id = Auth::user()->id;
        $user = User::find($id);

        // Validate the request data
        $validator = Validator::make($request->all(), [
            'currentPassword' => 'required|current_password',
            'newPassword' => 'required',
            'confirmPassword' => 'required|same:newPassword',
        ]);

        // If validation fails, return error response
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->toArray()
            ]);
        }

        // Save the required data from the request
        $user->password = Hash::make($request->newPassword);

        // If the user profile is successfully updated, return success response
        if ($user->save()) {
            return response()->json([
                'status' => 'success',
                'message' => 'User Password updated Successfully!'
            ]);
        } else {
            // If the user profile update fails, return error response
            return response()->json([
                'status' => 'error2',
                'message' => 'User Password update Failed!'
            ]);
        }
    }

    public function updateProfilePicture(Request $request)
    {
        // Get the id of the authenticated user
        $id = Auth::user()->id;
        $user = User::find($id);

        // Validate the request data
        $validator = Validator::make($request->all(), [
            'gambar' => 'required',
        ]);

        // If validation fails, return error response
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->toArray()
            ]);
        }

        // Save the uploaded image if there is one
        if ($request->hasFile('gambar')) {

            if ($user->foto_profil != null) {
                unlink($user->foto_profil);
            }

            // Save the uploaded image with a unique name
            $judul_tanpa_spasi = str_replace(' ', '-', auth()->user()->name);
            $nama_file = $judul_tanpa_spasi . '-' . hexdec(uniqid()) . '.' . $request->gambar->getClientOriginalExtension();

            // Save the image
            // $manager = new ImageManager(new Driver());

            Image::read($request->gambar)->save(public_path('/upload/profile_picture/'.$nama_file));

            $user->foto_profil = 'upload/profile_picture/' . $nama_file;
        } elseif ($request->gambarLama == null && $user->foto_profil != null) {
            // If not using the default image, remove the old image
            unlink($user->foto_profil);

            $user->foto_profil = '';
        } elseif ($request->gambarLama != null && $user->foto_profil != null && $user->foto_profil != 'upload/profile_picture/default/1.jpg') {
            // Get the file extension of the old image
            $file_ext = pathinfo($user->foto_profil, PATHINFO_EXTENSION);

            $judul_tanpa_spasi = str_replace(' ', '-', auth()->user()->name);
            $nama_file = $judul_tanpa_spasi . '-' . hexdec(uniqid()) . '.' . $file_ext;
            // Rename the old image file
            rename(public_path($user->foto_profil), public_path('upload/profile_picture/' . $nama_file));

            $user->foto_profil = 'upload/profile_picture/' . $nama_file;
        }

        // If the user profile is successfully updated, return success response
        if ($user->save()) {
            return response()->json([
                'status' => 'success',
                'message' => 'User Profile Picture updated Successfully!'
            ]);
        } else {
            // If the user profile update fails, return error response
            return response()->json([
                'status' => 'error2',
                'message' => 'User Profile Picture update Failed!'
            ]);
        }
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    function fetch()
    {
        // get data user yang login
        $user = Auth::user();

        return response()->json([
            'data' => $user
        ]);
    }
}
