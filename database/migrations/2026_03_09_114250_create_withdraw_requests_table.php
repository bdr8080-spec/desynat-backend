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
        Schema::create('withdraw_requests', function (Blueprint $table) {
            $table->id();

            $table->string('request_id');
            
            // 1-affiliate user, 2-user, 3-seller
            $table->tinyInteger('type')->comment('1-affiliate user, 2-user, 3-seller');
            
            // user_id after type
            $table->unsignedBigInteger('user_id')->comment('Reference to users table');

            // bankdetails_id after user_id
            $table->unsignedBigInteger('bankdetails_id')->comment('Reference to bankdetails table');

            $table->string('amount');
            
            // 0-pending, 1-approve, 2-reject
            $table->tinyInteger('admin_verify')->default(0)->comment('0-pending, 1-approve, 2-reject');
            
            $table->timestamps(); // creates created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdraw_requests');
    }
};