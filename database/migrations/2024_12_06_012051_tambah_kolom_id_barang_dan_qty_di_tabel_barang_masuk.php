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
        Schema::table('barang_masuks', function (Blueprint $table) {
            // Tambahkan kolom id_barang dan qty
            $table->foreignId('barang_id')->constrained('barangs', 'id');
            $table->integer('qty');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('barang_masuks', function (Blueprint $table) {
            // Hapus kolom id_barang dan qty
            $table->dropForeign(['barang_id']);
            $table->dropColumn('qty');
        });
    }
};
