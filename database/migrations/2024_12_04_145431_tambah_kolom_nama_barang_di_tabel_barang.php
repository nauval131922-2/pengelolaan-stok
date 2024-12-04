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
        Schema::table('Barangs', function (Blueprint $table) {
            // tambahkan kolom nama_barang
            $table->string('nama_barang');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('Barangs', function (Blueprint $table) {
            // hapus kolom nama_barang
            $table->dropColumn('nama_barang');
        });
    }
};
