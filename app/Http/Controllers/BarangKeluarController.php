<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Satuan;
use App\Models\Kategori;
use App\Models\BarangMasuk;
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

    public function fetchNamaBarangSpecific($id, Request $request)
    {
        // Ambil parameter 'tanggal' dari query string (URL)
        $tanggal = $request->query('tanggal');

        // ambil parameter 'id' dari request
        $idBarangKeluar = $request->query('idBarangKeluar');

        // Ambil data barang berdasarkan id
        $nama_barang = Barang::where('id', $id)->first();

        // Cek apakah barang ada
        if (!$nama_barang) {
            return response()->json(['error' => 'Barang tidak ditemukan'], 404);
        }

        // Ambil data kategori dan satuan barang
        $kategori = Kategori::find($nama_barang->kategori_id);
        $satuan = Satuan::find($nama_barang->satuan_id);

        // Hitung qty_masuk dan qty_keluar berdasarkan tanggal jika ada
        if ($tanggal) {
            $qty_masuk = BarangMasuk::where('barang_id', $nama_barang->id)
                ->whereDate('tanggal', '<=', $tanggal)
                ->sum('qty');

            // jika request $id ada, maka kecualikan data dengan id yang sama
            if ($idBarangKeluar) {
                $qty_keluar = BarangKeluar::where('barang_id', $nama_barang->id)
                    ->where('id', '!=', $idBarangKeluar)
                    ->whereDate('tanggal', '<=', $tanggal)
                    ->sum('qty');
            } else {
                $qty_keluar = BarangKeluar::where('barang_id', $nama_barang->id)
                    ->whereDate('tanggal', '<=', $tanggal)
                    ->sum('qty');
            }
        } else {
            // Jika tidak ada tanggal, hitung berdasarkan semua data
            $qty_masuk = BarangMasuk::where('barang_id', $nama_barang->id)->sum('qty');
            $qty_keluar = BarangKeluar::where('barang_id', $nama_barang->id)->sum('qty');
        }

        // Hitung saldo barang
        $saldo_barang = $qty_masuk - $qty_keluar;

        // Kembalikan response JSON
        return response()->json([
            'data' => [
                'id' => $nama_barang->id,
                'nama_barang' => $nama_barang->nama_barang,
                'kategori' => $kategori->nama_kategori,
                'satuan' => $satuan->nama_satuan,
                'saldo_barang' => $saldo_barang
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

        $title = 'Ubah Barang Keluar';

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
