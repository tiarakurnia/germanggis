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
        Schema::create('facilities', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->string('name'); // Facility name
            $table->foreignId('category_id')->constrained('categories'); // Foreign key to categories
            $table->text('description'); // Facility description
            $table->decimal('price', 10, 2); // Facility price
            $table->string('image')->nullable(); // Facility image
            $table->timestamps(); // Created at and updated at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facilities');
    }
};
