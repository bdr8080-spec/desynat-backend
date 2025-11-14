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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('seller_id');
            $table->string('store_id');
            $table->string('category_id');
            $table->string('subcategory_id');
            $table->string('brand_id');
            $table->string('other_en');
            $table->string('other_ar');
            $table->longText('product_name_en');
            $table->longText('product_name_ar');
            $table->longText('description_en')->nullable();
            $table->longText('description_ar')->nullable();


            $table->string('min_card_quantity')->nullable();
            $table->string('max_card_quantity')->nullable();

            $table->enum('product_return',['0','1'])->default('0')->comment('0 Not return 1 return Availble');
            $table->string('return_days')->nullable();

            $table->enum('product_exchangable',['0','1'])->default('0')->comment('0 Not 1 yes');
            $table->string('exchangable_days')->nullable();

            $table->enum('review_rating',['0','1'])->default('0')->comment('0 Not 1 yes');
           
            $table->enum('affiliated_product',['0','1'])->default('0')->comment('0 Not 1 yes');
           
            $table->enum('customized_product',['0','1'])->default('0')->comment('0 Not 1 yes');
           
            $table->enum('ready_to_ship',['0','1'])->default('0')->comment('0 Not 1 yes');
           
            $table->enum('cash_on_delivery',['0','1'])->default('0')->comment('0 Not 1 yes');

            $table->string('upload_size_chart')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};