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
        Schema::create('request_detail', function (Blueprint $table) {
            $table->id();
            $table->string('request_code', 20);
            $table->string('item_code', 20);
            $table->integer('qty');
            $table->integer('qty_accepted');
            $table->string('accepted_by')->nullable();
            $table->timestamps();

            $table->foreign('accepted_by')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('request_code')->references('id')->on('request')->onDelete('cascade');
            $table->foreign('item_code')->references('id')->on('items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_detail');
    }
};
