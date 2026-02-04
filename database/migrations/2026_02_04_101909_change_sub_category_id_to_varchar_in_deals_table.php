<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('deals', function (Blueprint $table) {
            // 1️⃣ Drop foreign key
            $table->dropForeign('deals_sub_category_id_foreign');

            // 2️⃣ Change column to VARCHAR
            $table->string('sub_category_id', 255)->index()->change();
        });
    }

    public function down()
    {
        Schema::table('deals', function (Blueprint $table) {
            // Revert back to BIGINT
            $table->unsignedBigInteger('sub_category_id')->change();

            // Re-add foreign key
            $table->foreign('sub_category_id')
                  ->references('id')
                  ->on('sub_categories')
                  ->onDelete('cascade');
        });
    }
};
