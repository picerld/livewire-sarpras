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
            $table->increments('id');
            $table->string('submissons_code', 20)->unique();
            $table->string('item_code', 20)->unique();
            $table->integer('qty');
            $table->integer('qty_accepted');
            $table->timestamps();

            $table->foreign('submissons_code')->references('code')->on('submission')->onDelete('cascade');
            $table->foreign('item_code')->references('code')->on('items')->onDelete('cascade');
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
