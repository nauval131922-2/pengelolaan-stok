<?php

use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KategoriController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/updatePassword', [ProfileController::class, 'updatePassword'])->name('profile.update.password');
    Route::post('/profile/updateProfilePicture', [ProfileController::class, 'updateProfilePicture'])->name('profile.update.profile.picture');
    Route::delete('/profile/destroy', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/fetch', [ProfileController::class, 'fetch'])->name('profile.fetch');

    Route::controller(SatuanController::class)->group(function () {
        Route::get('/master-satuan', 'index')->name('master-satuan-index');
        Route::get('/master-satuan/fetch', 'fetch')->name('master-satuan-fetch');
        Route::post('/master-satuan/simpan', 'simpan')->name('master-satuan-simpan');
        Route::get('/master-satuan/edit/{id}', 'edit')->name('master-satuan-edit');
        Route::post('/master-satuan/update/{id}', 'update')->name('master-satuan-update');
        Route::get('/master-satuan/hapus/{id}', 'hapus')->name('master-satuan-hapus');
    });

    Route::controller(KategoriController::class)->group(function () {
        Route::get('/master-kategori', 'index')->name('master-kategori-index');
        Route::get('/master-kategori/fetch', 'fetch')->name('master-kategori-fetch');
        Route::post('/master-kategori/simpan', 'simpan')->name('master-kategori-simpan');
        Route::get('/master-kategori/edit/{id}', 'edit')->name('master-kategori-edit');
        Route::post('/master-kategori/update/{id}', 'update')->name('master-kategori-update');
        Route::get('/master-kategori/hapus/{id}', 'hapus')->name('master-kategori-hapus');
    });

    Route::controller(BarangController::class)->group(function () {
        Route::get('/master-barang', 'index')->name('master-barang-index');
        Route::get('/master-barang/fetch', 'fetch')->name('master-barang-fetch');
        Route::post('/master-barang/simpan', 'simpan')->name('master-barang-simpan');
        Route::get('/master-barang/edit/{id}', 'edit')->name('master-barang-edit');
        Route::post('/master-barang/update/{id}', 'update')->name('master-barang-update');
        Route::get('/master-barang/hapus/{id}', 'hapus')->name('master-barang-hapus');
    });

});

require __DIR__.'/auth.php';
