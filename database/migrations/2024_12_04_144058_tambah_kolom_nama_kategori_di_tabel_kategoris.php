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
        Schema::table('Kategoris', function (Blueprint $table) {
            // tambah kolom nama_kategori di tabel Kategoris
            $table->string('nama_kategori');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('Kategoris', function (Blueprint $table) {
            // hapus kolom nama_kategori di tabel Kategoris
            $table->dropColumn('nama_kategori');
        });
    }
};
