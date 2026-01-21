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
        Schema::create('affilated_users', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable()->comment("get id from User Table");
            $table->longText('profile_image')->nullable();
            $table->string('full_name');
            $table->string('country_code');
            $table->string('mobile');
            $table->string('email');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->longText('document1')->nullable();
            $table->longText('document2')->nullable();            
            $table->string('otp')->nullable();            
            $table->string('otp_verify')->default('0')->comment('0 pending , 1 verify otp'); 
            $table->longText('reject_reason')->nullable();           
            $table->string('device_type')->default('0')->comment('0 web 1 ios 2 andriod');
            $table->longText('device_token')->nullable();
            $table->longText('let')->nullable();
            $table->longText('long')->nullable();
           
            
            $table->enum('address_update_status',['0','1'])->default('0')->comment('This column Check Address Status');
            $table->enum('bank_update_status',['0','1'])->default('0')->comment('This column Check Bank Status');

            $table->enum('admin_verify',['0','1','2','3','4'])->default('0')->comment('	0 pending 1 user submit 2 admin verify 3 admin reject 4 document reject	');
            
            $table->rememberToken();
            $table->string('status')->default('1')->comment('0 inactive,1 active');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('affilated_users');
    }
};