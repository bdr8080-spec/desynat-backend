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
        Schema::create('seller_store_information', function (Blueprint $table) {
            $table->id();
            $table->UNSIGNEDBigInteger('seller_id');
            $table->foreign('seller_id')->references('id')->on('sellers')->onDelete('cascade');

            $table->string('store_image');
            $table->string('store_name');
            $table->string('country');
            $table->string('store_address');
            $table->string('address_line1');
            $table->string('address_line2');
            $table->string('store_phone');
            $table->string('store_mail_id');
            $table->longText('bio');
            $table->longText('let')->nullable();
            $table->longText('long')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seller_store_information');
    }
};
