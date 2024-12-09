<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Satuan;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PenggunaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $semua_pengguna = User::all();
        $title = 'Pengguna';
        $sub_title = 'Pengguna';

        $placeholderSelect2 = 'Select an option';

        return view('backend.pengguna.index', compact('semua_pengguna', 'title', 'sub_title', 'placeholderSelect2'));
    }

    function fetch()
    {
        $semua_pengguna = User::where('id', '!=', auth()->user()->id)->get();

        return response()->json(['data' => $semua_pengguna]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function simpan(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'username' => 'required|unique:users,username',
            'password' => 'required',
            'confirmPassword' => 'required|same:password',
        ]);

        // If validation fails, return error response
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->toArray()
            ]);
        }

        // Save the required data from the request
        $pengguna = new User;
        $pengguna->name = $request->name;
        $pengguna->username = $request->username;
        $pengguna->password = bcrypt($request->password);

        // If the user profile is successfully updated, return success response
        if ($pengguna->save()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil disimpan!'
            ]);
        } else {
            // If the user profile update fails, return error response
            return response()->json([
                'status' => 'error2',
                'message' => 'Data gagal disimpan!'
            ]);
        }
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $pengguna = User::find($id);

        $title = 'Ubah Pengguna';

        return response()->json([
            'data' => $pengguna,
            'title' => $title
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'username' => 'required|unique:users,username,' . $id,
        ]);

        // If validation fails, return error response
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->toArray()
            ]);
        }

        // Save the required data from the request
        $pengguna = User::find($id);
        $pengguna->name = $request->name;
        $pengguna->username = $request->username;

        // jika password diisikan, maka update password
        if ($request->password) {
            // jika confirm password tidak sesuai, maka return error
            if ($request->password != $request->confirmPassword) {
                return response()->json([
                    'status' => 'error2',
                    'message' => 'Password tidak sesuai!'
                ]);
            }

            $pengguna->password = bcrypt($request->password);
        }


        // If the user profile is successfully updated, return success response
        if ($pengguna->save()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil disimpan!'
            ]);
        } else {
            // If the user profile update fails, return error response
            return response()->json([
                'status' => 'error2',
                'message' => 'Data gagal disimpan!'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function hapus($id)
    {
        $pengguna = User::find($id);

        // jika berhasil dihapus
        if ($pengguna->delete()) {
            return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus.']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Gagal menghapus data.']);
        }
    }
}
