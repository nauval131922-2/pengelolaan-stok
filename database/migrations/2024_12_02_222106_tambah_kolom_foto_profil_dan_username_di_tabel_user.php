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
        Schema::table('Users', function (Blueprint $table) {
            // tambah kolom foto_profil dan username di tabel Users
            $table->string('foto_profil');
            $table->string('username');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('Users', function (Blueprint $table) {
            // hapus kolom foto_profil dan username di tabel Users
            $table->dropColumn('foto_profil');
            $table->dropColumn('username');
        });
    }
};
