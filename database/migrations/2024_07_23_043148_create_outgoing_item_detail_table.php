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
            $table->string('outgoing_item_code', 20)->unique();
            $table->string('item_code', 20)->unique();
            $table->integer('qty');
            $table->timestamps();

            $table->foreign('outgoing_item_code')->references('code')->on('outgoing_item')->cascadeOnDelete();
            $table->foreign('item_code')->references('code')->on('items')->cascadeOnDelete();
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
