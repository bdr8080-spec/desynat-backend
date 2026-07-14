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
        Schema::create('seller_story_prices', function (Blueprint $table) {

            $table->id();

            // Country ID from countries table
            $table->unsignedBigInteger('country_id');

            // Price per day
            $table->string('per_day_price');

            $table->timestamps();


            // Foreign key
            $table->foreign('country_id')
                ->references('id')
                ->on('countries')
                ->onDelete('cascade');


            // Optional: prevent duplicate country pricing
            $table->unique('country_id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seller_story_prices');
    }
};