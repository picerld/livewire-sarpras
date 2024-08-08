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
        Schema::create('items', function (Blueprint $table) {
<<<<<<< Updated upstream
            $table->string('code', 10)->primary();
=======
            $table->string('id', 20)->primary();
>>>>>>> Stashed changes
            $table->string('name', 100);
            $table->string('merk', 25);
            $table->string('unit', 10);
            $table->string('images')->nullable();
            $table->integer('price');
            $table->integer('stock')->default(0);
            $table->integer('minimum_stock')->default(0);
            $table->foreignId('category_id')->constrained('category')->cascadeOnDelete();
            $table->text('description');
            $table->timestamps();
<<<<<<< Updated upstream

            $table->foreign('category_id')->references('id')->on('category')->cascadeOnDelete();
=======
>>>>>>> Stashed changes
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
