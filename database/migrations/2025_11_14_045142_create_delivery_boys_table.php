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
        Schema::create('delivery_boys', function (Blueprint $table) {
            $table->id();
            $table->string('profile_pic')->nullable();
            $table->string('full_name_english');
            $table->string('full_name_arabic');
            $table->string('email')->unique();
            $table->string('country_code');
            $table->string('mobile');
            $table->string('password');
            $table->string('address_line1');
            $table->string('address_line2')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('let')->nullable();
            $table->string('long')->nullable();
            $table->foreignId('country_id')->default(1)->constrained('countries')->onDelete('cascade'); // assuming there's a 'countries' table
            $table->foreignId('zone_id')->constrained('zones')->onDelete('cascade'); // assuming there's a 'zones' table
            $table->string('otp')->nullable();
            $table->enum('otp_verify', ['0', '1'])->default('0')->comment('0 pending 1 verify');
            $table->enum('device_type', ['1', '2'])->default('1')->comment('1 ios 2 android');
            $table->longText('device_token')->nullable();
            $table->string('vehicle_name');
            $table->string('vehicle_reg_no');
            $table->string('document_information')->default('0')->comment('0 not upload 1 upload');
            $table->string('status')->default('1')->comment('0 inactive 1 active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_boys');
    }
};
