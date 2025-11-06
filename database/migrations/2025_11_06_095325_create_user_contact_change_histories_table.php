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
        Schema::create('user_contact_change_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id') ->constrained() ->onDelete('cascade'); 
            $table->string('email')->nullable();
            $table->string('country_code', 10)->nullable(); 
            $table->string('mobile', 20)->nullable(); 
            $table->enum('otp_verify', ['0', '1']) ->default('0') ->comment('0 = not verified, 1 = verified'); 
            $table->enum('status', ['0', '1']) ->default('0') ->comment('0 = inactive, 1 = active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_contact_change_histories');
    }
};