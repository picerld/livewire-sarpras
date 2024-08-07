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
        Schema::create('employees', function (Blueprint $table) {
<<<<<<< Updated upstream
            $table->id();
            $table->string('nip', 20)->unique();
=======
            $table->string('nip')->primary();
            $table->string('email', 50)->unique();
>>>>>>> Stashed changes
            $table->string('avatar')->nullable();
            $table->string('name', 50);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('employees');
        Schema::dropIfExists('pegawai');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
