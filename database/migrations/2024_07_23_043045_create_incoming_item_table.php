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
        Schema::create('incoming_items', function (Blueprint $table) {
            $table->string('id', 20)->primary();
            $table->string('nip', 20);
            $table->foreignId('supplier_id')->constrained('suppliers')->onDelete('cascade');
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
        Schema::dropIfExists('incoming_items');
    }
};
