<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('Satuans', function (Blueprint $table) {
            // tambah kolom nama_satuan di tabel Satuans
            $table->string('nama_satuan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('Satuans', function (Blueprint $table) {
            // hapus kolom nama_satuan di tabel Satuans
            $table->dropColumn('nama_satuan');
        });
    }
};
