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
        Schema::create('user_gift_cards', function (Blueprint $table) {
            $table->id();
            $table->longText('order_id')->nullable();
            $table->string('user_id')->comment("User table id");
            $table->integer('gift_card_id')->nullable();
            $table->string('amount');
            $table->string('receiver_id')->nullable(); 
            $table->string('receiver_name')->nullable();
            $table->string('receiver_email')->nullable();
            $table->string('sender_name')->nullable();
            $table->string('sender_email')->nullable();
            $table->longText('wish_message')->nullable();
            $table->longText('notes')->nullable();       

            $table->enum('payment_status',['0','1','2'])->default('0')->comment('0 pending 1 paid 2 cancel');
            $table->longText('transaction_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_gift_cards');
    }
};
