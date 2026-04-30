<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('seller_store_visitors', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id')->nullable(); 

            $table->unsignedBigInteger('seller_id');
            $table->unsignedBigInteger('store_id');

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seller_store_visitors');
    }
};