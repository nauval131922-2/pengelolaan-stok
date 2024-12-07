<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Satuan;
use App\Models\Kategori;
use App\Models\BarangMasuk;
use App\Models\KartuStok;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KartuStokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $semua_kartu_stok = KartuStok::all();
        $title = 'Kartu Stok';
        $sub_title = 'Kartu Stok';

        $placeholderSelect2 = 'Cari Barang';

        $kategori = Kategori::all();
        $satuan = Satuan::all();

        return view('backend.kartu_stok.index', compact('semua_kartu_stok', 'title', 'sub_title', 'kategori', 'satuan', 'placeholderSelect2'));
    }

    function fetchNamaBarang()
    {
        $nama_barang = Barang::all();

        return response()->json([
            'data' => $nama_barang
        ]);
    }

    public function fetch($idBarang, $tanggalMulai, $tanggalAkhir)
    {
        try {
            // Query data berdasarkan parameter
            $kartuStok = KartuStok::with(['kategori', 'satuan'])
                ->where('id_barang', $idBarang)
                ->whereBetween('tanggal', [$tanggalMulai, $tanggalAkhir])
                ->get();

            // Format respons JSON
            return response()->json([
                'success' => true,
                'data' => $kartuStok,
            ]);
        } catch (\Exception $e) {
            // Tangani error
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data: ' . $e->getMessage(),
            ], 500);
        }
    }
}
