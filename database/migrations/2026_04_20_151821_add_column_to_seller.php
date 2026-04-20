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
        Schema::table('sellers', function (Blueprint $table) {
            $table->enum('type',['0','1'])->default('0')->comment('0 normal user 1 staff Management')->after('id');
            $table->string('parent_id')->nullable()->after('type')->comment('when type is 1');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sellers', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('parent_id');
            //
        });
    }
};
