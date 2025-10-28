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
        Schema::create('sellers', function (Blueprint $table) {
            $table->id();
            $table->string('profile_pic')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('country_code');
            $table->string('mobile');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('accept_terms',['0','1'])->default('0')->comment('0 pending 1 accept');
            $table->string('otp')->nullable();
            $table->string('otp_verify')->default('0')->comment('0 pending 1 verify');
            $table->string('device_type')->default('0')->comment('0 web 1 ios 2 andriod');
            $table->longText('device_token')->nullable();
            $table->enum('admin_verify',['0','1'])->default('0')->comment('0 pending 1 user submit 2 admin verify 4 admin reject');

            $table->string('store_information')->default('0')->comment('0 not upload 1 upload');
            $table->string('bank_information')->default('0')->comment('0 not upload 1 upload');

           
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sellers');
    }
};
