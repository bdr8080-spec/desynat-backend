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
        Schema::create('affiliate_product_click_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable()->comment('Reference to users table');
            $table->unsignedBigInteger('product_id')->comment('Reference to products table');
            $table->unsignedBigInteger('affiliate_id')->comment('Reference to users table for affiliate');
            $table->unsignedBigInteger('affiliate_product_id')->comment('Reference to affiliate products table');
            $table->string('reference_link')->nullable()->comment('Optional reference link for tracking');

            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('affiliate_product_click_records');
    }
};