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
        Schema::create('deals', function (Blueprint $table) {
            $table->id();

            $table->string('image');
            $table->string('name_english');
            $table->string('name_arabic');

            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('sub_category_id');

            $table->string('discount');

            $table->string('from');
            $table->string('to');

            $table->tinyInteger('status')
                  ->default(1)
                  ->comment('1 = Active, 0 = Inactive');

            $table->timestamps();

            // Foreign keys
            $table->foreign('category_id')
                  ->references('id')
                  ->on('categories')
                  ->onDelete('cascade');

            $table->foreign('sub_category_id')
                  ->references('id')
                  ->on('sub_categories')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deals');
    }
};
