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
        Schema::create('incoming_item', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('supplier_id');
=======
        Schema::create('incoming_items', function (Blueprint $table) {
            $table->string('code', 20)->primary();
            $table->string('nip');
            $table->string('supplier_code', 20)->unique();
>>>>>>> Stashed changes
=======
        Schema::create('incoming_items', function (Blueprint $table) {
            $table->string('code', 20)->primary();
            $table->unsignedBigInteger('nip');
            $table->string('supplier_code', 20)->unique();
>>>>>>> faa95b83bec67b4ce7b381a422654c3e64f2496c
            $table->integer('total_items')->default(0);
            $table->timestamps();

            $table->foreign('nip', 'employee_nip')
                ->references('nip')
                ->on('employees')
                ->onDelete('cascade');

            $table->foreign('supplier_code')->references('code')->on('suppliers')->cascadeOnDelete();
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
