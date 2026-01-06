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
        Schema::create('full_banners', function (Blueprint $table) {
            $table->id();

            $table->string('image');

            // MUST match all_countries.id (INT)
            $table->integer('country_id');

            $table->string('start_date');
            $table->string('end_date');

            $table->tinyInteger('status')
                  ->default(1)
                  ->comment('1-active, 0-inactive');

            $table->timestamps();

            $table->foreign('country_id')
                  ->references('id')
                  ->on('all_countries')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('full_banners');
    }
};
