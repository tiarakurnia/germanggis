<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama pemesan
            $table->integer('price'); // Harga per item
            $table->integer('quantity'); // Kuantitas
            $table->integer('total'); // Total harga
            $table->date('booking_date')->nullable(); // Tanggal pemesanan
            $table->string('image')->nullable(); // Gambar fasilitas
            $table->text('description')->nullable(); // Deskripsi fasilitas
            $table->enum('status', ['pending', 'confirmed', 'shipped', 'completed'])->default('pending'); // Status pesanan
            $table->timestamps(); // Waktu pembuatan dan pembaruan data
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
