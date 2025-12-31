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
           
            $table->string('tax')->nullable()->after('amount')->comment();
            $table->string('shipping_fees')->nullable()->after('tax')->comment();
            $table->string('promocode_id')->nullable()->after('shipping_fees')->comment();
            $table->string('promocode_value')->nullable()->after('promocode_id')->comment('every amount divided accoring to orderdetails quantity');
            $table->string('giftcard_id')->nullable()->after('promocode_value')->comment();
            $table->string('giftcard_amount')->nullable()->after('giftcard_id')->comment('every amount divided accoring to orderdetails quantity');
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orderdetails', function (Blueprint $table) {
            $table->dropColumn('tax');
            $table->dropColumn('shipping_fees');
            $table->dropColumn('promocode_id');
            $table->dropColumn('promocode_value');
            $table->dropColumn('giftcard_id');
            $table->dropColumn('giftcard_amount');
            
        });
    }
};