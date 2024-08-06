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
        Schema::create('incoming_item', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 20)->unique();
            $table->string('nip', 20)->unique();
            $table->string('supplier_code', 20)->unique();
            $table->integer('total_items')->default(0);
            $table->timestamps();

            $table->foreign('nip')->references('nip')->on('employees')->cascadeOnDelete();
            $table->foreign('supplier_code')->references('code')->on('suppliers')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incoming_item');
    }
};
