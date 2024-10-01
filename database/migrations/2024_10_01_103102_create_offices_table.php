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
        Schema::create('office', function (Blueprint $table) {
            $table->integerIncrements('id')->primary();
            $table->string('code_office', 10);
            $table->string('office_name', 45);
            $table->string('address');
            $table->string('pic_name', 45);
            $table->string('email', 45);
            $table->string('phone', 20);
            $table->boolean('status');
            $table->unsignedInteger('vendor_id');
            $table->foreign('vendor_id')->references('id')->on('vendor');
            $table->unsignedInteger('province_id');
            $table->foreign('province_id')->references('id')->on('province');
            $table->unsignedInteger('city_id');
            $table->foreign('city_id')->references('id')->on('city');
            $table->unsignedInteger('district_id');
            $table->foreign('district_id')->references('id')->on('district');
            $table->unsignedInteger('subdistrict_id');
            $table->foreign('subdistrict_id')->references('id')->on('subdistrict');
            $table->unsignedInteger('poscode_id');
            $table->foreign('poscode_id')->references('id')->on('poscode');
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users');
            $table->unsignedBigInteger('updated_by');
            $table->foreign('updated_by')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('office');
    }
};
