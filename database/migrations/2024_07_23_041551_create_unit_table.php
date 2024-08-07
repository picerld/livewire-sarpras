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
        Schema::create('users', function (Blueprint $table) {
<<<<<<< HEAD
<<<<<<< Updated upstream
            $table->id();
            $table->string('email', 50);
=======
            $table->string('nip', 20)->primary();
            $table->string('username', 50);
>>>>>>> Stashed changes
=======
            $table->unsignedBigInteger('nip', 20)->primary();
            $table->string('username', 50);
>>>>>>> faa95b83bec67b4ce7b381a422654c3e64f2496c
            $table->string('password');
            $table->enum('role', ['admin', 'unit', 'pengawas'])->default('unit');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('nip')->references('nip')->on('employees')->onDelete('cascade');
            
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unit');
        Schema::dropIfExists('users');
    }
};
