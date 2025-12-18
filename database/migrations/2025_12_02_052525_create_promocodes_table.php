<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('promocodes', function (Blueprint $table) {
            $table->id();

            // Foreign key: country_id
            $table->unsignedBigInteger('country_id');
            $table->foreign('country_id')
                  ->references('id')
                  ->on('countries')
                  ->onDelete('cascade');

            $table->string('name_english', 255);
            $table->string('name_arabic', 255);

            $table->longText('description_english');
            $table->longText('description_arabic');

            $table->tinyInteger('applicable_for')
                  ->default(1)
                  ->comment('1-first order, 2-all order');

            $table->string('discount_percent', 255);
            $table->string('min_order_value', 255);

            $table->string('upto_discount');

            $table->date('start_date');
            $table->date('end_date');

            $table->tinyInteger('status')
                  ->default(1)
                  ->comment('0-inactive, 1-active');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('promocodes');
    }
};
