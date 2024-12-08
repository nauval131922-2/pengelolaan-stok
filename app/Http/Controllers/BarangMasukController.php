<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Satuan;
use App\Models\Kategori;
use App\Models\BarangMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BarangMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $semua_barang_masuk = BarangMasuk::all();
        $title = 'Barang Masuk';
        $sub_title = 'Barang Masuk';

        $kategori = Kategori::all();
        $satuan = Satuan::all();

        $placeholderSelect2 = 'Select an option';

        return view('backend.barang_masuk.index', compact('semua_barang_masuk', 'title', 'sub_title', 'kategori', 'satuan', 'placeholderSelect2'));
    }

    function fetch()
    {
        $semua_barang_masuk = BarangMasuk::with('barang')->get();

        foreach ($semua_barang_masuk as $barang_masuk) {
            $barang = $barang_masuk->barang;
            $kategori = Kategori::find($barang->kategori_id);
            $satuan = Satuan::find($barang->satuan_id);
            $barang->nama_kategori = $kategori->nama_kategori;
            $barang->nama_satuan = $satuan->nama_satuan;
        }

        return response()->json(['data' => $semua_barang_masuk]);
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
        $barang_masuk = new BarangMasuk;
        $barang_masuk->barang_id = $request->nama_barang;
        $barang_masuk->qty = $request->qty;
        $barang_masuk->tanggal = $request->tanggal;

        // If the user profile is successfully updated, return success response
        if ($barang_masuk->save()) {
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
    public function show(BarangMasuk $barang_masuk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $barang_masuk = BarangMasuk::find($id);

        $title = 'Ubah BarangMasuk';

        return response()->json([
            'data' => $barang_masuk,
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
        $barang_masuk = BarangMasuk::find($id);
        $barang_masuk->barang_id = $request->nama_barang;
        $barang_masuk->qty = $request->qty;
        $barang_masuk->tanggal = $request->tanggal;

        // If the user profile is successfully updated, return success response
        if ($barang_masuk->save()) {
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
        $barang_masuk = BarangMasuk::find($id);

        // jika berhasil dihapus
        if ($barang_masuk->delete()) {
            return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus.']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Gagal menghapus data.']);
        }
    }
}
