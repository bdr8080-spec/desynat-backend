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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id');
            $table->longText('variant_image')->nullable();
            $table->sting('parent_child')->default('0')->comment('0 parent and  Child id ');
            $table->string('color_id');
            $table->string('size_id');
            $table->string('bust')->nullable();
            $table->string('waist')->nullable();
            $table->string('hip')->nullable();
            $table->string('shoulder')->nullable();
            $table->string('sleeve_length')->nullable();
            $table->string('length')->nullable();
            $table->string('total_stock')->nullable();
            $table->string('sku')->nullable();
            $table->string('sku_threshold_value')->nullable();
            $table->string('actual_price');
          
            $table->enum('discount_type',['1','2'])->default('1')->comment('1 percentage 2 fixed Price');
            $table->string('discount_value');
            $table->string('final_price');
            
            $table->enum('status',['0','1'])->default('1')->comment('1 active 0 inactive');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};