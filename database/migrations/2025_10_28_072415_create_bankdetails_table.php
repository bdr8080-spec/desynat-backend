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
        Schema::create('bankdetails', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->enum('type',['0','1','2'])->default('1')->comment('0 user 1 seller 2 admin');
            $table->enum('account_type',['0','1'])->comment('0 Personal 1 Busness');
            $table->string('iban');
            $table->string('swift');
            $table->string('bank_name');
            $table->string('account_holder_name');
            $table->LongText('upload_proof')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bankdetails');
    }
};
