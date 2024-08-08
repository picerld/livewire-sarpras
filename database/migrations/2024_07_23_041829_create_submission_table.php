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
        Schema::create('submission', function (Blueprint $table) {
<<<<<<< Updated upstream
            $table->string('code', 20)->primary();
            $table->unsignedBigInteger('nip');
=======
            $table->string('id', 20)->primary();
            $table->string('nip', 20);
>>>>>>> Stashed changes
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
        Schema::dropIfExists('submission');
    }
};
