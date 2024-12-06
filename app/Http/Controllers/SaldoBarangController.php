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

        $kategori = Kategori::all();
        $satuan = Satuan::all();

        return view('backend.saldo_barang.index', compact('semua_saldo_barang', 'title', 'sub_title', 'kategori', 'satuan'));
    }

    function fetch()
    {
        $semua_barang = Barang::with('kategori', 'satuan')->get();

        // saldo barang itu di ambil dari qty di barang masuk - qty di barang keluar
        foreach ($semua_barang as $barang) {
            $qty_masuk = BarangMasuk::where('barang_id', $barang->id)->sum('qty');
            $qty_keluar = BarangKeluar::where('barang_id', $barang->id)->sum('qty');
            $barang->saldo_barang = $qty_masuk - $qty_keluar; // Tambahkan saldo ke objek barang
        }
        return response()->json(['data' => $semua_barang]);
    }
}
