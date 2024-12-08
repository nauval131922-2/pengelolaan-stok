<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Satuan;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $semua_barang = Barang::all();
        $title = 'Master Barang';
        $sub_title = 'Barang';

        $kategori = Kategori::all();
        $satuan = Satuan::all();

        $placeholderSelect2 = 'Select an option';

        return view('backend.master-barang.index', compact('semua_barang', 'title', 'sub_title', 'kategori', 'satuan', 'placeholderSelect2'));
    }

    function fetch()
    {
        $semua_barang = Barang::with('kategori', 'satuan')->get();

        return response()->json([
            'data' => $semua_barang
        ]);
    }

    function fetchSatuan()
    {
        $satuan = Satuan::all();

        return response()->json([
            'data' => $satuan
        ]);
    }

    function fetchKategori()
    {
        $kategori = Kategori::all();

        return response()->json([
            'data' => $kategori
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
            'barang' => 'required|unique:barangs,nama_barang',
            'kategori' => 'required',
            'satuan' => 'required',
        ]);

        // If validation fails, return error response
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->toArray()
            ]);
        }

        // Save the required data from the request
        $barang = new Barang;
        $barang->nama_barang = $request->barang;
        $barang->kategori_id = $request->kategori;
        $barang->satuan_id = $request->satuan;

        // If the user profile is successfully updated, return success response
        if ($barang->save()) {
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
    public function show(Barang $barang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $barang = Barang::find($id);

        $title = 'Ubah Barang';

        return response()->json([
            'data' => $barang,
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
            'barang' => 'required|unique:barangs,nama_barang,' . $id,
            'kategori' => 'required',
            'satuan' => 'required',
        ]);

        // If validation fails, return error response
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->toArray()
            ]);
        }

        // Save the required data from the request
        $barang = Barang::find($id);
        $barang->nama_barang = $request->barang;
        $barang->kategori_id = $request->kategori;
        $barang->satuan_id = $request->satuan;

        // If the user profile is successfully updated, return success response
        if ($barang->save()) {
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
        $barang = Barang::find($id);

        // jika berhasil dihapus
        if ($barang->delete()) {
            return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus.']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Gagal menghapus data.']);
        }
    }
}
