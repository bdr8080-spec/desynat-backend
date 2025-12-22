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
        Schema::create('product_ratings', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('order_id');
            $table->integer('orderdetails_id');
            $table->integer('product_id');
            $table->string('product_rating')->nullable();
            $table->longText('product_review')->nullable();
            $table->longText('product_image')->nullable();
            

            $table->integer('store_id');
            $table->string('store_rating')->nullable();
            $table->longText('store_review')->nullable();
            $table->longText('store_image')->nullable();
            

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_ratings');
    }
};