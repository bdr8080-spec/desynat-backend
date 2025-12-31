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
        Schema::create('orderdetails', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id');
            $table->integer('user_id');
            $table->integer('product_id');
            $table->integer('variants_id');
            $table->integer('quantity');
            $table->string('amount')->nullable();
            $table->enum('status',['0','1'])->default('1')->comment('1 active 0 inactive');            
            $table->timestamps();
            $table->string('delivery_boy_id')->nullable();
            $table->string('assign_status',['0','1'])->default('0')->comment('1 yes 0 no'); 
            $table->string('assign_date')->nullable();
            $table->string('cancel_reason')->nullable();
            $table->string('is_picked',['0','1'])->default('0')->comment('1 yes 0 no');
            $table->string('not_delivered_reason')->nullable();
            $table->string('seller_id')->nullable();
            $table->string('admin_commission')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orderdetails');
    }
};
