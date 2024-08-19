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
            $table->string('id', 20)->primary();
            $table->string('name', 100);
            $table->enum('unit', ['Pcs', 'Box', 'Rim'])->default('Pcs');
            $table->string('images')->nullable();
            $table->integer('price');
            $table->integer('stock')->default(0);
            $table->integer('minimum_stock')->default(0);
            $table->unsignedBigInteger('category_id')->nullable();
            $table->text('description');
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('category')->onDelete('set null');
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
