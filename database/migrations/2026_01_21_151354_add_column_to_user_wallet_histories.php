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
        Schema::table('user_wallet_histories', function (Blueprint $table) {
            $table->string('unique_id')->after('id');
            $table->string('payment_method')->nullable()->comment('1 online 2 wallet 3 cod');
            $table->enum('payment_status',['0','1','2'])->default('0')->comment('0 pending 1 success 2 cancelled/failed');
            $table->enum('addedby',['1','2'])->default('1')->comment("1 admin 2 User");
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_wallet_histories', function (Blueprint $table) {
            //
        });
    }
};