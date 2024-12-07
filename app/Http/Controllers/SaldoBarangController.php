<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Satuan;
use App\Models\Kategori;
use App\Models\BarangMasuk;
use App\Models\SaldoBarang;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SaldoBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $semua_saldo_barang = SaldoBarang::all();
        $title = 'Saldo Barang';
        $sub_title = 'Saldo Barang';

        $placeholderSelect2 = '';

        $kategori = Kategori::all();
        $satuan = Satuan::all();

        return view('backend.saldo_barang.index', compact('semua_saldo_barang', 'title', 'sub_title', 'kategori', 'satuan', 'placeholderSelect2'));
    }

    public function fetch($tanggal)
    {
        // Ambil semua barang dengan kategori dan satuan terkait
        $semua_barang = Barang::with('kategori', 'satuan')->get();

        foreach ($semua_barang as $barang) {
            // Ambil qty masuk dan qty keluar berdasarkan tanggal
            $qty_masuk = BarangMasuk::where('barang_id', $barang->id)
                ->whereDate('tanggal', '<=', $tanggal)  // Filter berdasarkan tanggal
                ->sum('qty');

            $qty_keluar = BarangKeluar::where('barang_id', $barang->id)
                ->whereDate('tanggal', '<=', $tanggal)  // Filter berdasarkan tanggal
                ->sum('qty');

            // Hitung saldo barang
            $barang->saldo_barang = $qty_masuk - $qty_keluar;
        }

        return response()->json(['data' => $semua_barang]);
    }
}
