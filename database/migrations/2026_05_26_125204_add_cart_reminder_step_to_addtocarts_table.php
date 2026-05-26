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
            $table->integer('cart_reminder_step')->default(0)->after('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('addtocarts', function (Blueprint $table) {
            $table->dropColumn('cart_reminder_step');
        });
    }
};