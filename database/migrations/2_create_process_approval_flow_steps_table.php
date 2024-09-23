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
        Schema::create('process_approval_flow_steps', static function (Blueprint $table) {
            $table->id();
            $table->foreignId('process_approval_flow_id')->constrained('process_approval_flows')->cascadeOnDelete();
            $table->enum('role', ['admin', 'unit', 'pengawas'])->default('pengawas');
            $table->json('permissions')->nullable();
            $table->integer('order')->nullable()->index();
            $table->enum('action', ['APPROVE', 'VERIFY', 'CHECK'])->default('APPROVE');
            $table->tinyInteger('active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('process_approval_flow_steps');
    }
};
