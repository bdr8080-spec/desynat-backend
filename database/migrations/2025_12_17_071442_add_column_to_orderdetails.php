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

            $table->enum('r_e_approve',['0','1','2'])->default('0')->comment('0 pending 1 accepted 2 rejected');
            
            $table->longText('return_reason')->nullable();
            
            $table->longText('return_image')->nullable();

            $table->longText('exchange_reason')->nullable();
            $table->longText('exchange_new_size')->nullable();
            $table->longText('exchange_old_size')->nullable();

            $table->enum('payment_status',['0','1','2','3'])->default('0')->comment('0 pending 1 paid 2 cancel or reject 3 refund');
        
            $table->string('delivery_status')->default('1')->comment(' 1 all 2 onging 3 delivered 5 return 6 return request Accept 7 return request Accept');


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