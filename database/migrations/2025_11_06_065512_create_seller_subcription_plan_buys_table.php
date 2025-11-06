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
        Schema::create('seller_subcription_plan_buys', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id');
            $table->unsignedBigInteger('seller_id');
            $table->unsignedBigInteger('plan_id');
            $table->enum('status',['0','1'])->default('0')->comment('0 inactive 1 active');
            
            $table->string('online_transaction_id')->nullable();
            $table->string('payment_status')->nullable()->comment('0 not paid 1 Paid 2 cancel');
            $table->foreign('seller_id')
            ->references('id')
            ->on('sellers')
            ->onDelete('cascade');
            $table->foreign('plan_id')
            ->references('id')
            ->on('plans')
            ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seller_subcription_plan_buys');
    }
};