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
        Schema::create('allproductchats', function (Blueprint $table) {
            $table->id();
            $table->string('unique_id');
            $table->enum('type',['1','2'])->comment('1 Normal 2 order Cutom Order Request');
            $table->integer('user_id');
            $table->integer('seller_id');
            $table->string('product_id')->nullable();
            $table->string('variation_id')->nullable();
            $table->string('price')->nullable();
            $table->string('quantity')->nullable();
            $table->string('delivery_address')->nullable();

            $table->string('shipping')->nullable();
            $table->string('tax')->nullable();
            $table->string('total_amount')->nullable();
            $table->string('custom_details')->nullable();
            $table->enum('product_request',['0','1'])->default('0')->comment(' 0 not request 1 order send request');

            $table->enum('action',['0','1','2','3','4'])->default('0')->comment(' 0 pending 1 seller accept 2 seller modify  3 seller cancel 4 User cancel');
            $table->enum('addtocardStatus',['0','1'])->default('0')->comment(' 0 mean not in card 1 in card');
            $table->enum('product_buy_status',['0','1'])->default('0')->comment('0 not buy 1 buy ');
          
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('allproductchats');
    }
};