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
        Schema::table('service_cities', function (Blueprint $table) {
            // Add new column after country_id
            $table->unsignedBigInteger('city_id')->after('country_id');

            // If city_id references cities table:
            $table->foreign('city_id')
                  ->references('id')
                  ->on('cities')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_cities', function (Blueprint $table) {
            // Drop foreign key first
            $table->dropForeign(['city_id']);
            $table->dropColumn('city_id');
        });
    }
};
