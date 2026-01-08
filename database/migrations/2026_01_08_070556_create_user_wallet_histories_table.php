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
        Schema::create('user_wallet_histories', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');

            $table->tinyInteger('type')
                  ->default(1)
                  ->comment('1-credit, 2-debit, 3-giftcard redeem');

            $table->string('transaction_id')->nullable();

            $table->string('amount');

            $table->timestamps();

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_wallet_histories');
    }
};
