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
        Schema::create('incoming_item_detail', function (Blueprint $table) {
            $table->id();
            $table->string('incoming_item_code', 20);
            $table->string('item_code', 20);
            $table->integer('qty')->default(0);
            $table->timestamps();

            $table->foreign('incoming_item_code')->references('id')->on('incoming_items')->cascadeOnDelete();
            $table->foreign('item_code')->references('id')->on('items')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incoming_item_detail');
    }
};
