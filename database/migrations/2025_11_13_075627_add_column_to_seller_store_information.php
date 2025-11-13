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
        Schema::table('seller_store_information', function (Blueprint $table) {
            $table->integer('Store_Availability')->default('1')->comment('0 is off , 1 is On');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seller_store_information', function (Blueprint $table) {
            $table->dropColumn('Store_Availability');
        });
    }
    
};