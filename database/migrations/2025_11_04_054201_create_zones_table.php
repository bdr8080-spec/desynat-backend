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
        Schema::create('zones', function (Blueprint $table) {
            $table->id();

            // Foreign keys
            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('city_id');

            // Zone details
            $table->string('name_english');
            $table->string('name_arabic');
            $table->json('coordinates'); // stores polygon points from Google Maps

            // Status: 0 = inactive, 1 = active
            $table->tinyInteger('status')->default(1)->comment('0 - inactive, 1 - active');

            // Timestamps
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('country_id')
                  ->references('id')
                  ->on('countries')
                  ->onDelete('cascade');

            $table->foreign('city_id')
                  ->references('id')
                  ->on('service_cities')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zones');
    }
};
