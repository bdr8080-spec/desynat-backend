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
        Schema::create('order_record_details', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('orderdetails_id');
            $table->unsignedBigInteger('driver_id');

            $table->string('assign_date')->nullable();
            $table->string('not_delivered_date')->nullable();
            $table->string('next_delivery_date')->nullable();

            $table->timestamps();

            // Optional foreign keys (recommended)
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('orderdetails_id')->references('id')->on('orderdetails')->onDelete('cascade');
            $table->foreign('driver_id')->references('id')->on('delivery_boys')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_record_details');
    }
};
