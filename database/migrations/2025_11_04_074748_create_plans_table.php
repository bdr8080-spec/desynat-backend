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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('country_id');
            $table->string('plan_name_english');
            $table->string('plan_name_arabic');
            $table->integer('duration'); 
            $table->tinyInteger('duration_type')->comment('1 - monthly, 2 - yearly');
            $table->integer('no_of_videos');
            $table->integer('no_of_products');
            $table->integer('no_of_highlights');
            $table->integer('no_of_employee');
            $table->tinyInteger('stories')->comment('0 - close, 1 - open');
            $table->decimal('price', 10, 2)->comment('Plan price');
            $table->decimal('discounted_price', 10, 2)->nullable()->comment('New Plan price');
            $table->tinyInteger('commission')->comment('0 - no, 1 - yes');
            $table->decimal('commission_percentage', 5, 2)->nullable()->comment('Commission percentage');
            $table->tinyInteger('status')->default(1)->comment('0 - inactive, 1 - active');
            $table->timestamps();

            $table->foreign('country_id')
                  ->references('id')
                  ->on('countries')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
