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
        Schema::create('orders', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->foreignId('user_id')->constrained('users'); // Foreign key to users
            $table->foreignId('facility_id')->constrained('facilities'); // Foreign key to facilities
            $table->foreignId('name')->constrained('facilities'); // Facility name
            $table->decimal('price', 10, 2); // Price of the facility
            $table->integer('quantity'); // Quantity ordered
            $table->decimal('total', 10, 2); // Total price
            $table->dateTime('order_date'); // Order date
            $table->string('image')->nullable(); // Image of the facility
            $table->timestamps(); // Created at and updated at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
