<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Satuan;
use App\Models\Kategori;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BarangKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $semua_barang_keluar = BarangKeluar::all();
        $title = 'Barang Keluar';
        $sub_title = 'Barang Keluar';

        $kategori = Kategori::all();
        $satuan = Satuan::all();

        return view('backend.barang_keluar.index', compact('semua_barang_keluar', 'title', 'sub_title', 'kategori', 'satuan'));
    }

    function fetch()
    {
        $semua_barang_keluar = BarangKeluar::with('barang')->get();

        foreach ($semua_barang_keluar as $barang_keluar) {
            $barang = $barang_keluar->barang;
            $kategori = Kategori::find($barang->kategori_id);
            $satuan = Satuan::find($barang->satuan_id);
            $barang->nama_kategori = $kategori->nama_kategori;
            $barang->nama_satuan = $satuan->nama_satuan;
        }

        return response()->json(['data' => $semua_barang_keluar]);
    }

    function fetchNamaBarang()
    {
        $nama_barang = Barang::all();

        return response()->json([
            'data' => $nama_barang
        ]);
    }

    function fetchNamaBarangSpecific($id)
    {
        $nama_barang = Barang::where('id', $id)->first();

        // nama kategori dan satuan
        $kategori = Kategori::find($nama_barang->kategori_id);
        $satuan = Satuan::find($nama_barang->satuan_id);

        // return response
        return response()->json([
            'data' => [
                'id' => $nama_barang->id,
                'nama_barang' => $nama_barang->nama_barang,
                'kategori' => $kategori->nama_kategori,
                'satuan' => $satuan->nama_satuan
            ],
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
            'nama_barang' => 'required',
            'kategori' => 'required',
            'satuan' => 'required',
            'qty' => 'required',
            'tanggal' => 'required',
        ]);

        // If validation fails, return error response
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->toArray()
            ]);
        }

        // Save the required data from the request
        $barang_keluar = new BarangKeluar;
        $barang_keluar->barang_id = $request->nama_barang;
        $barang_keluar->qty = $request->qty;
        $barang_keluar->tanggal = $request->tanggal;

        // If the user profile is successfully updated, return success response
        if ($barang_keluar->save()) {
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
    public function show(BarangKeluar $barang_keluar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $barang_keluar = BarangKeluar::find($id);

        $title = 'Ubah BarangKeluar';

        return response()->json([
            'data' => $barang_keluar,
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
            'nama_barang' => 'required',
            'kategori' => 'required',
            'satuan' => 'required',
            'qty' => 'required',
            'tanggal' => 'required',
        ]);

        // If validation fails, return error response
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->toArray()
            ]);
        }

        // Save the required data from the request
        $barang_keluar = BarangKeluar::find($id);
        $barang_keluar->barang_id = $request->nama_barang;
        $barang_keluar->qty = $request->qty;
        $barang_keluar->tanggal = $request->tanggal;

        // If the user profile is successfully updated, return success response
        if ($barang_keluar->save()) {
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
        $barang_keluar = BarangKeluar::find($id);

        // jika berhasil dihapus
        if ($barang_keluar->delete()) {
            return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus.']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Gagal menghapus data.']);
        }
    }
}
