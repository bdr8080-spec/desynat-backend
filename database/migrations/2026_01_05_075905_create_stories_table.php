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
        Schema::create('stories', function (Blueprint $table) {
            $table->id();

            $table->tinyInteger('type')
                  ->default(1)
                  ->comment('1 = Admin, 2 = Seller');

            $table->unsignedBigInteger('seller_id')
                  ->nullable()
                  ->comment('Reference to sellers table');

            $table->string('file');

            $table->tinyInteger('status')
                  ->default(1)
                  ->comment('1 = Active, 0 = Expired');

            $table->timestamps();

            // Foreign key
            $table->foreign('seller_id')
                  ->references('id')
                  ->on('sellers')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stories');
    }
};
