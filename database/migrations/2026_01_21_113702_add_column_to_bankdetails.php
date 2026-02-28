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
        Schema::table('bankdetails', function (Blueprint $table) {
            $table->string('account_no')->nullable()->after('id');
            $table->enum('default_account',['0','1'])->default('0')->comment('0 not selected 1 selected');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bankdetails', function (Blueprint $table) {
            $table->dropColumn('account_no');
        });
    }
};