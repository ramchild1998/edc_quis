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
        Schema::create('maping_area', function (Blueprint $table) {
            $table->integerIncrements('id')->primary();
            $table->unsignedInteger('area_id');
            $table->foreign('area_id')->references('id')->on('area');
            $table->unsignedInteger('subdistrict_id');
            $table->foreign('subdistrict_id')->references('id')->on('subdistrict');
            $table->boolean('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maping_area');
    }
};
