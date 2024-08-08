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
<<<<<<< HEAD
<<<<<<< Updated upstream
        Schema::create('outgoing_item', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
=======
        Schema::create('outgoing_items', function (Blueprint $table) {
            $table->string('code', 20)->primary();
            $table->string('nip');
            $table->integer('total_items')->default(0);
>>>>>>> Stashed changes
=======
        Schema::create('outgoing_items', function (Blueprint $table) {
<<<<<<< Updated upstream
            $table->string('code', 20)->primary();
            $table->unsignedBigInteger('nip');
=======
            $table->string('id', 20)->primary();
            $table->string('nip', 20);
>>>>>>> Stashed changes
            $table->integer('total_items')->default(0);
>>>>>>> faa95b83bec67b4ce7b381a422654c3e64f2496c
            $table->timestamps();

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
