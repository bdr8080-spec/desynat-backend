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
            $table->string('reference_link')->after('unique_id');
            $table->string('affiliate_id')->after('reference_link')->comment('Affilate user Id');
            $table->string('affiliate_commission')->after('affiliate_id');
            $table->string('affiliate_admin_commission')->after('affiliate_commission');
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orderdetails', function (Blueprint $table) {
          $table->dropColumn('reference_link');
          $table->dropColumn('affiliate_id');
          $table->dropColumn('affiliate_commission');
          $table->dropColumn('affiliate_admin_commission');
          
            //
        });
    }
};