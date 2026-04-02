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
        Schema::create('live_requests', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('timeslot_id');
            $table->unsignedBigInteger('seller_id');
            $table->unsignedBigInteger('order_id')->nullable();

            $table->tinyInteger('admin_verify')
                  ->default(0)
                  ->comment('0-new, 1 = Accept, 2 = Reject');

            $table->string('reject_reason')->nullable();


            $table->string('channel_id')->nullable();
            $table->string('uid')->nullable();


            $table->timestamps();

            // Foreign keys
            $table->foreign('timeslot_id')
                  ->references('id')
                  ->on('live_request_timeslots')
                  ->onDelete('cascade');

            $table->foreign('seller_id')
                  ->references('id')
                  ->on('sellers')
                  ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('live_requests');
    }
};