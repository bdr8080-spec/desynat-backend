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
            $table->enum('order_type',['1','2'])->default('1')->comment('1 Normal Order 2 Custom Order')->after('user_id');
            $table->string('unique_id')->nullable()->comment("custom order unique id when type 2 found");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('addtocarts', function (Blueprint $table) {
            $table->dropColumn('order_type'); 
            $table->dropColumn('unique_id');
        });
    }
};