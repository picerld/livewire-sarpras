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
        Schema::create('request', function (Blueprint $table) {
            $table->string('id', 20)->primary();
            $table->string('nip', 20);
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->string('regarding', 50);
            $table->integer('total_items')->default(0);
            $table->timestamps();

            $table->foreign('nip')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request');
    }
};
