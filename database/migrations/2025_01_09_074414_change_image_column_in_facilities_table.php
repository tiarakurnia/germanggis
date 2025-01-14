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
        Schema::table('facilities', function (Blueprint $table) {
            $table->longtext('image')->change();// Mengubah kolom 'image' menjadi tipe TEXT
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('facilities', function (Blueprint $table) {
            // Mengembalikan kolom 'image' ke tipe VARCHAR(255) atau sesuai dengan definisi sebelumnya
            $table->string('image', 255)->change();
        });
    }
};
