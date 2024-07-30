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
            $table->id();
            $table->string('name', 100);
            $table->string('code', 10);
            $table->string('merk', 25);
            $table->string('unit', 10);
            $table->string('images')->nullable();
            $table->integer('price');
            $table->integer('stock')->default(0);
            $table->integer('minimum_stock')->default(0);
            $table->unsignedBigInteger('category_id');
            $table->text('description');
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('category')->cascadeOnDelete();
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