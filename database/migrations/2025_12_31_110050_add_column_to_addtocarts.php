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
        Schema::table('addtocarts', function (Blueprint $table) {
            
            $table->string('tax')->nullable()->after('amount');
            $table->string('shipping_fees')->nullable()->after('shipping_fees');
    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('addtocarts', function (Blueprint $table) {

            $table->dropColumn('tax');
            $table->dropColumn('shipping_fees');
            
        });
    }
};