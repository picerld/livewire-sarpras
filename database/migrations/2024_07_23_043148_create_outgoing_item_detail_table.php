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
        Schema::create('outgoing_item_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('outgoing_item_id');
            $table->integer('qty');
            $table->timestamps();

            $table->foreign('outgoing_item_id')->references('id')->on('outgoing_item')->cascadeOnDelete();
            $table->foreignId('item_id')->constrained('item')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outgoing_item_detail');
    }
};
