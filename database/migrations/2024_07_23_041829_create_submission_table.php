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
<<<<<<< HEAD
<<<<<<< Updated upstream
            $table->id();
            $table->unsignedBigInteger('user_id');
=======
            $table->string('code', 20)->primary();
            $table->string('nip');
            $table->integer('total_items')->default(0);
>>>>>>> Stashed changes
=======
            $table->string('code', 20)->primary();
            $table->unsignedBigInteger('nip');
            $table->integer('total_items')->default(0);
>>>>>>> faa95b83bec67b4ce7b381a422654c3e64f2496c
            $table->timestamps();

            $table->foreign('nip', 'nip_employee')
                ->references('nip')
                ->on('employees')
                ->onDelete('cascade');
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
