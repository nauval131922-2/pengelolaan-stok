<?php

namespace App\Http\Controllers;

use App\Models\Satuan;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSatuanRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UpdateSatuanRequest;

class SatuanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $semua_satuan = Satuan::all();
        $title = 'Master Satuan';
        $sub_title = 'Satuan';

        $placeholderSelect2 = '';

        return view('backend.master-satuan.index', compact('semua_satuan', 'title', 'sub_title', 'placeholderSelect2'));
    }

    function fetch()
    {
        $semua_satuan = Satuan::all();

        return response()->json([
            'data' => $semua_satuan
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function simpan(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'satuan' => 'required|unique:satuans,nama_satuan',
        ]);

        // If validation fails, return error response
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->toArray()
            ]);
        }

        // Save the required data from the request
        $satuan = new Satuan;
        $satuan->nama_satuan = $request->satuan;


        // If the user profile is successfully updated, return success response
        if ($satuan->save()) {
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
     * Display the specified resource.
     */
    public function show(Satuan $satuan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $satuan = Satuan::find($id);

        $title = 'Ubah Satuan';

        return response()->json([
            'data' => $satuan,
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
            'satuan' => 'required|unique:satuans,nama_satuan,' . $id,
        ]);

        // If validation fails, return error response
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->toArray()
            ]);
        }

        // Save the required data from the request
        $satuan = Satuan::find($id);
        $satuan->nama_satuan = $request->satuan;

        // If the user profile is successfully updated, return success response
        if ($satuan->save()) {
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
        $satuan = Satuan::find($id);

        // jika berhasil dihapus
        if ($satuan->delete()) {
            return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus.']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Gagal menghapus data.']);
        }
    }
}
