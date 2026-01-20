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
        Schema::create('affilated_user_addresses', function (Blueprint $table) {
            $table->id();

            $table->UNSIGNEDBigInteger('affiliate_id');
            $table->foreign('affiliate_id')->references('id')->on('affilated_users')->onDelete('cascade');
            $table->string('country')->nullable();
            $table->longText('locations')->nullable();
            $table->longText('address1')->nullable();
            $table->longText('address2')->nullable();
            $table->longText('pincode')->nullable();
            $table->longText('town')->nullable();
            $table->longText('state')->nullable();
            $table->longText('city')->nullable();
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
        Schema::dropIfExists('affilated_user_addresses');
    }
};