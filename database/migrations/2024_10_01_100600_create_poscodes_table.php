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
        Schema::create('poscode', function (Blueprint $table) {
            $table->integerIncrements('id')->primary();
            $table->unsignedInteger('poscode');
            $table->unsignedInteger('subdistrict_id');
            $table->foreign('subdistrict_id')->references('id')->on('subdistrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('poscode');
    }
};
