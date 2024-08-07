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
            $table->id();
            $table->unsignedBigInteger('user_id');
=======
            $table->string('code', 20)->primary();
            $table->string('nip');
            $table->integer('total_items')->default(0);
>>>>>>> Stashed changes
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
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
