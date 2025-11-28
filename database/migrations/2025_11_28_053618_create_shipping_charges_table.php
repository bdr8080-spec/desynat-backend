<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipping_charges', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('country_id');

            $table->decimal('range_from', 8, 2);
            $table->decimal('range_to', 8, 2);

            $table->decimal('shipping_fee', 8, 2);

            $table->tinyInteger('status')
                ->default(1)
                ->comment('0-inactive, 1-active');

            $table->timestamps();

            // Foreign key constraint
            $table->foreign('country_id')
                ->references('id')
                ->on('countries')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipping_charges');
    }
};
