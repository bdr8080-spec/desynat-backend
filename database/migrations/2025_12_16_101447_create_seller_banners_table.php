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
        Schema::create('seller_banners', function (Blueprint $table) {
            $table->id();
            $table->string('order_id');
            $table->integer('seller_id');
            $table->string('banner_position')->comment('1 homeTop 2 home Banner 3 category');
            $table->string('category')->nullable();
            $table->string('subcatgory')->nullable();
            
            $table->string('start_date');
            $table->string('end_date');
            $table->string('total_days');
            $table->longText('upload_banner');
            $table->string('price');
            $table->enum('Admin_verify',['0','1','2'])->comment('0')->comment('0 pending 1 Approve 2 rejected');
            $table->enum('payment_status',['0','1','2'])->default('0')->comment(' 0 pending 1 paid 2 Cancelled 3 Failed');
            $table->string('transaction_id')->nullable();
            $table->longText('cancelled_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seller_banners');
    }
};