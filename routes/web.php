<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SatuanController;
use Illuminate\Support\Facades\Route;

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
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // profile-fetch
    Route::get('/profile/fetch', [ProfileController::class, 'fetch'])->name('profile.fetch');

    Route::controller(SatuanController::class)->group(function () {
        Route::get('/master-satuan', 'index')->name('master-satuan-index');
        Route::get('/master-satuan/fetch', 'fetch')->name('master-satuan-fetch');
        // Route::get('/mata-pelajaran/tambah', 'tambah')->name('mata-pelajaran-tambah');
        // Route::post('/mata-pelajaran/simpan', 'simpan')->name('mata-pelajaran-simpan');
        // Route::get('/mata-pelajaran/edit/{id}', 'edit')->name('mata-pelajaran-edit');
        // Route::post('/mata-pelajaran/update/{id}', 'update')->name('mata-pelajaran-update');
        // Route::get('/mata-pelajaran/hapus/{id}', 'hapus')->name('mata-pelajaran-hapus');
    });

});

require __DIR__.'/auth.php';
