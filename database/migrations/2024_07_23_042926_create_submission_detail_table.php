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
        Schema::create('submission_detail', function (Blueprint $table) {
            $table->id();
            $table->string('submission_code', 20);
            $table->string('item_code', 20);
            $table->integer('qty');
            $table->integer('qty_accepted');
            $table->timestamps();

            $table->foreign('submission_code')->references('id')->on('submission')->onDelete('cascade');
            $table->foreign('item_code')->references('id')->on('items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submission_detail');
    }
};
