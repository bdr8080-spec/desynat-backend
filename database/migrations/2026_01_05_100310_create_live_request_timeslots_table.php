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
        Schema::create('live_request_timeslots', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('country_id');

            $table->string('date');

            $table->string('from');
            $table->string('to');

            $table->tinyInteger('status')
                  ->default(1)
                  ->comment('1 = Active, 0 = Inactive');

            $table->timestamps();

            // Foreign key
            $table->foreign('country_id')
                  ->references('id')
                  ->on('countries')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('live_request_timeslots');
    }
};
