<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Satuan;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PenggunaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $semua_pengguna = User::all();
        $title = 'Pengguna';
        $sub_title = 'Pengguna';

        $placeholderSelect2 = 'Select an option';

        return view('backend.pengguna.index', compact('semua_pengguna', 'title', 'sub_title', 'placeholderSelect2'));
    }

    function fetch()
    {
        $semua_pengguna = Pengguna::with('pengguna')->get();

        foreach ($semua_pengguna as $pengguna) {
            $pengguna = $pengguna->pengguna;
            $kategori = Kategori::find($pengguna->kategori_id);
            $satuan = Satuan::find($pengguna->satuan_id);
            $pengguna->nama_kategori = $kategori->nama_kategori;
            $pengguna->nama_satuan = $satuan->nama_satuan;
        }

        return response()->json(['data' => $semua_pengguna]);
    }

    function fetchNamapengguna()
    {
        $nama_pengguna = pengguna::all();

        return response()->json([
            'data' => $nama_pengguna
        ]);
    }

    public function fetchNamapenggunaSpecific($id, Request $request)
    {
        // Ambil parameter 'tanggal' dari query string (URL)
        $tanggal = $request->query('tanggal');

        // ambil parameter 'id' dari request
        $idPengguna = $request->query('idPengguna');

        // Ambil data pengguna berdasarkan id
        $nama_pengguna = pengguna::where('id', $id)->first();

        // Cek apakah pengguna ada
        if (!$nama_pengguna) {
            return response()->json(['error' => 'pengguna tidak ditemukan'], 404);
        }

        // Ambil data kategori dan satuan pengguna
        $kategori = Kategori::find($nama_pengguna->kategori_id);
        $satuan = Satuan::find($nama_pengguna->satuan_id);

        // Hitung qty_masuk dan qty_keluar berdasarkan tanggal jika ada
        if ($tanggal) {
            $qty_masuk = penggunaMasuk::where('pengguna_id', $nama_pengguna->id)
                ->whereDate('tanggal', '<=', $tanggal)
                ->sum('qty');

            // jika request $id ada, maka kecualikan data dengan id yang sama
            if ($idPengguna) {
                $qty_keluar = Pengguna::where('pengguna_id', $nama_pengguna->id)
                    ->where('id', '!=', $idPengguna)
                    ->whereDate('tanggal', '<=', $tanggal)
                    ->sum('qty');
            } else {
                $qty_keluar = Pengguna::where('pengguna_id', $nama_pengguna->id)
                    ->whereDate('tanggal', '<=', $tanggal)
                    ->sum('qty');
            }
        } else {
            // Jika tidak ada tanggal, hitung berdasarkan semua data
            $qty_masuk = penggunaMasuk::where('pengguna_id', $nama_pengguna->id)->sum('qty');
            $qty_keluar = Pengguna::where('pengguna_id', $nama_pengguna->id)->sum('qty');
        }

        // Hitung saldo pengguna
        $saldo_pengguna = $qty_masuk - $qty_keluar;

        // Kembalikan response JSON
        return response()->json([
            'data' => [
                'id' => $nama_pengguna->id,
                'nama_pengguna' => $nama_pengguna->nama_pengguna,
                'kategori' => $kategori->nama_kategori,
                'satuan' => $satuan->nama_satuan,
                'saldo_pengguna' => $saldo_pengguna
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
            'nama_pengguna' => 'required',
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
        $pengguna = new Pengguna;
        $pengguna->pengguna_id = $request->nama_pengguna;
        $pengguna->qty = $request->qty;
        $pengguna->tanggal = $request->tanggal;

        // If the user profile is successfully updated, return success response
        if ($pengguna->save()) {
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
    public function show(Pengguna $pengguna)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $pengguna = Pengguna::find($id);

        $title = 'Ubah Pengguna';

        return response()->json([
            'data' => $pengguna,
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
            'nama_pengguna' => 'required',
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
        $pengguna = Pengguna::find($id);
        $pengguna->pengguna_id = $request->nama_pengguna;
        $pengguna->qty = $request->qty;
        $pengguna->tanggal = $request->tanggal;

        // If the user profile is successfully updated, return success response
        if ($pengguna->save()) {
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
        $pengguna = Pengguna::find($id);

        // jika berhasil dihapus
        if ($pengguna->delete()) {
            return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus.']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Gagal menghapus data.']);
        }
    }
}
