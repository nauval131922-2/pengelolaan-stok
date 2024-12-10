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
use Dompdf\Dompdf;
use Dompdf\Options;

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

        return view('backend.saldo_barang.index', compact('semua_saldo_barang', 'title', 'sub_title', 'placeholderSelect2'));
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
    public function pdf($tanggal)
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

        // format tanggal dd mmmm yyyy
        $tanggal = date('d F Y', strtotime($tanggal));

        // gunakan bulan dalam bahasa Indonesia
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

        $tanggal = str_replace(array_keys($bulan), array_values($bulan), $tanggal);

        $data = [
            'title' => 'Saldo Barang per Tanggal ' . $tanggal,
            'semua_barang' => $semua_barang,
        ];

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->setIsRemoteEnabled(true);

        $dompdf = new Dompdf($options);
        $html = view('backend.saldo_barang.pdfAll', $data)->render();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4, portrait');
        $dompdf->render();

        return response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="saldo-barang.pdf"',
        ]);
    }
}
