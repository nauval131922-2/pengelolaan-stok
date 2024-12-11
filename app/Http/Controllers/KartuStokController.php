<?php

namespace App\Http\Controllers;

use Log;
use Dompdf\Dompdf;
use Dompdf\Options;
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

    public function pdf($idBarang, $tanggalMulai, $tanggalAkhir)
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

            // nama satuan dari barang
            $namaSatuan = Barang::find($idBarang)->satuan->nama_satuan;

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

            // Format tanggal menjadi "dd mmmm yyyy" dalam bahasa Indonesia
            $bulan = [
                'January' => 'Januari',
                'February' => 'Februari',
                'March' => 'Maret',
                'April' => 'April',
                'May' => 'Mei',
                'June' => 'Juni',
                'July' => 'Juli',
                'August' => 'Agustus',
                'September' => 'September',
                'October' => 'Oktober',
                'November' => 'November',
                'December' => 'Desember',
            ];

            $tanggalMulaiFormatted = str_replace(array_keys($bulan), array_values($bulan), date('d F Y', strtotime($tanggalMulai)));
            $tanggalAkhirFormatted = str_replace(array_keys($bulan), array_values($bulan), date('d F Y', strtotime($tanggalAkhir)));

            // nama barang
            $barang = Barang::find($idBarang);
            if ($barang) {
                $namaBarang = $barang->nama_barang;
            } else {
                $namaBarang = 'Barang tidak ditemukan';
            }

            $bulan = [
                'January' => 'Januari',
                'February' => 'Februari',
                'March' => 'Maret',
                'April' => 'April',
                'May' => 'Mei',
                'June' => 'Juni',
                'July' => 'Juli',
                'August' => 'Agustus',
                'September' => 'September',
                'October' => 'Oktober',
                'November' => 'November',
                'December' => 'Desember',
            ];

            // tanggal awal
            $tanggalAwal = date('d F Y', strtotime($tanggalMulai));
            $tanggalAwal = str_replace(array_keys($bulan), array_values($bulan), $tanggalAwal);

            // tanggal akhir
            $tanggalAkhir = date('d F Y', strtotime($tanggalAkhir));
            $tanggalAkhir = str_replace(array_keys($bulan), array_values($bulan), $tanggalAkhir);

            $data = [
                'title' => 'Laporan Kartu Stok Barang ' . $namaBarang . ' (' . $tanggalMulaiFormatted . ' - ' . $tanggalAkhirFormatted . ')',
                'title2' => 'Laporan Kartu Stok Barang',
                'tanggalMulai' => $tanggalMulaiFormatted,
                'tanggalAkhir' => $tanggalAkhirFormatted,
                'saldoAwal' => $saldoAwal,
                'kartuStok' => $kartuStok->values(),
                'namaSatuan' => $namaSatuan,
                'namaBarang' => $namaBarang,
                'tanggalAwal' => $tanggalAwal,
                'tanggalAkhir' => $tanggalAkhir,
            ];

            $options = new Options();
            $options->set('isHtml5ParserEnabled', true);
            $options->setIsRemoteEnabled(true);

            $dompdf = new Dompdf($options);
            $html = view('backend.kartu_stok.pdf', $data)->render();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            return response($dompdf->output(), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="kartu-stok-barang.pdf"',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat PDF: ' . $e->getMessage(),
            ], 500);
        }
    }
}
