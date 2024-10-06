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
        Schema::create('outgoing_items', function (Blueprint $table) {
            $table->string('id', 20)->primary();
            $table->string('nip', 20);
            $table->enum('status', ['taken', 'not taken'])->default('not taken');
            $table->integer('total_items')->default(0);
            $table->string('request_code', 25)->nullable();
            $table->timestamps();
            
            $table->foreign('request_code')->references('id')->on('request')->nullOnDelete();
            $table->foreign('nip')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outgoing_items');
    }
};
