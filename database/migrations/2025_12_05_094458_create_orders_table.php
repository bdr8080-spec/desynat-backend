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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->enum('order_type',['0','1'])->default('0')->comment('0 Normal order 1 custom');
            $table->string('order_id');
            
            $table->integer('user_id');

            $table->integer('delivery_address');

            $table->string('total_mrp');
            $table->string('discount_mrp')->nullable();
            $table->enum('promocode_status',['yes','no'])->default('no');
            $table->string('promocode_id')->nullable();
            $table->string('promocode_value')->nullable();            
            $table->string('shipping_fees')->nullable();

            $table->string('tax')->nullable();
            $table->string('shipping_fees')->nullable();
            
            $table->string('giftcard_id')->nullable();
            $table->string('giftcard_amount')->nullable();
            $table->string('total_amount');

           
            $table->string('payment_method')->nullable()->comment(' 1 myfatoorah 2 wallet 3 Cod');
            $table->enum('payment_status',['0','1','2','3'])->default('0')->comment('0 pending 1 paid 2 cancel or reject 3 refund');

            $table->enum('delivery_status',['1','2','3','4','5'])->default('1')->comment(' 1 all 2 onging 3 delivered 4 cancelled 5 return ');
            $table->string('transaction_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
