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
            $table->string('code', 20)->primary();
            $table->unsignedBigInteger('nip');
            $table->string('supplier_code', 20)->unique();
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
