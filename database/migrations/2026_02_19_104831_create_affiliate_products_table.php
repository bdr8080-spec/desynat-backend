<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('affiliate_products', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('affiliate_id');
            $table->unsignedBigInteger('product_id');

            $table->timestamps();

            // Prevent duplicate entries
            $table->unique(['affiliate_id', 'product_id']);

            // Optional foreign keys (recommended)
            $table->foreign('product_id')
                  ->references('id')
                  ->on('products')
                  ->onDelete('cascade');

            // If you have users table:
            // $table->foreign('affiliate_id')
            //       ->references('id')
            //       ->on('users')
            //       ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('affiliate_products');
    }
};
