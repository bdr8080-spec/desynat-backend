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
        Schema::table('orderdetails', function (Blueprint $table) {
        
            $table->enum('return_type',['0','1','2'])->default('0')->comment('0 Null 1 Return 2 exchange');
        
            $table->enum('payment_status',['0','1','2','3'])->default('0')->comment('0 pending 1 paid 2 cancel or reject 3 refund');
            $table->enum('delivery_status',['1','2','3','4','5'])->default('1')->comment(' 1 all 2 onging 3 delivered 4 cancelled 5 return ');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orderdetails', function (Blueprint $table) {
            //
        });
    }
};