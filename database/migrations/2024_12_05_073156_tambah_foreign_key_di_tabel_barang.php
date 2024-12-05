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
            // tambahkan foreign key di kolom kategori_id
            $table->foreignId('kategori_id')->constrained();
            // tambahkan foreign key di kolom satuan_id
            $table->foreignId('satuan_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('Barangs', function (Blueprint $table) {
            //  hapus foreign key di kolom kategori_id
            $table->dropForeign(['kategori_id']);
            //  hapus foreign key di kolom satuan_id
            $table->dropForeign(['satuan_id']);
        });
    }
};
