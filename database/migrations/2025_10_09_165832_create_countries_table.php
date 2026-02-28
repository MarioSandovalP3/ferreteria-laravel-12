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
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name_es',100)->nullable();
            $table->string('name_en',100)->nullable();
            $table->string('country_code',10)->nullable();
            $table->string('image',100)->nullable();
            $table->string('iso_code',50)->nullable();
            $table->string('currency',50)->nullable();
            $table->string('currency_symbol',10)->nullable();
            $table->string('timezone',100)->nullable();
            $table->string('utc_offset',10)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
