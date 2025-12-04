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
        Schema::create('stock_inventory_records', function (Blueprint $table) {
            $table->id();
            $table->enum('user_type',['0','1','2'])->default('1')->comment('0 admin 1 Seller 2 user');
            $table->string('user_id')->nullable();
            $table->string('product_id')->nullable();
            $table->string('total_stock')->nullable();
            $table->string('sku')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_inventory_records');
    }
};