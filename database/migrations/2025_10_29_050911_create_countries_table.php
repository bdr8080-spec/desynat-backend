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
            $table->string('name');
            $table->string('iso_code');
            $table->string('currency_name');
            $table->string('currency_code');
            $table->string('currency_symbol');
            $table->string('dial_code');
            $table->string('flag');
            $table->string('flag1');
            $table->string('exchange_rate_to_kwd');
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
