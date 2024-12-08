<?php

namespace App\Http\Controllers;

use Log;
use App\Models\Barang;
use App\Models\Satuan;
use App\Models\Kategori;
use App\Models\KartuStok;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log as logg;

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
            // Ambil data BarangMasuk sebelum tanggal awal
            $masukSebelumAwal = BarangMasuk::where('barang_id', $idBarang)
                ->where('tanggal', '<', $tanggalMulai)
                ->sum('qty');

            // Ambil data BarangKeluar sebelum tanggal awal
            $keluarSebelumAwal = BarangKeluar::where('barang_id', $idBarang)
                ->where('tanggal', '<', $tanggalMulai)
                ->sum('qty');

            // Hitung saldo awal
            $saldoAwal = $masukSebelumAwal - $keluarSebelumAwal;

            // Ambil data BarangMasuk dengan kondisi tanggal dan barang
            $kartuStok = BarangMasuk::with('barang.kategori', 'barang.satuan')
                ->where('barang_id', $idBarang)
                ->whereBetween('tanggal', [$tanggalMulai, $tanggalAkhir])
                ->select('tanggal', 'barang_id', 'qty as debit', DB::raw('0 as kredit'))
                ->get()
                ->concat(BarangKeluar::with('barang.kategori', 'barang.satuan')
                    ->where('barang_id', $idBarang)
                    ->whereBetween('tanggal', [$tanggalMulai, $tanggalAkhir])
                    ->select('tanggal', 'barang_id', DB::raw('0 as debit'), 'qty as kredit')
                    ->get())
                ->sortBy('tanggal');

            // Hitung saldo kumulatif
            $saldo = $saldoAwal;
            $kartuStok = $kartuStok->map(function ($item) use (&$saldo) {
                $barang = $item->barang; // Relasi ke tabel Barang
                $kategori = $barang->kategori; // Relasi ke tabel Kategori
                $satuan = $barang->satuan; // Relasi ke tabel Satuan

                $saldo += $item->debit - $item->kredit;

                return [
                    'tanggal' => $item->tanggal,
                    'nama_barang' => $barang->nama_barang,
                    'kategori' => $kategori->nama_kategori,
                    'debit' => $item->debit,
                    'kredit' => $item->kredit,
                    'saldo' => $saldo,
                    'satuan' => $satuan->nama_satuan,
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $kartuStok->values(), // Reset indeks array
                'saldoAwal' => $saldoAwal,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data: ' . $e->getMessage(),
            ], 500);
        }
    }
}
