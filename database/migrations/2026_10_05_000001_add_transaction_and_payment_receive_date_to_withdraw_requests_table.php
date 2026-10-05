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
        Schema::table('withdraw_requests', function (Blueprint $table) {
            if (!Schema::hasColumn('withdraw_requests', 'transaction_id')) {
                $table->string('transaction_id')->nullable()->after('amount');
            }

            if (!Schema::hasColumn('withdraw_requests', 'payment_receive_date')) {
                $table->dateTime('payment_receive_date')->nullable()->after('transaction_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('withdraw_requests', function (Blueprint $table) {
            if (Schema::hasColumn('withdraw_requests', 'payment_receive_date')) {
                $table->dropColumn('payment_receive_date');
            }

            if (Schema::hasColumn('withdraw_requests', 'transaction_id')) {
                $table->dropColumn('transaction_id');
            }
        });
    }
};
