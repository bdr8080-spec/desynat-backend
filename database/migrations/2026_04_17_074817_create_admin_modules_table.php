<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admin_modules', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // e.g. brand_management
            $table->string('display_name');   // e.g. Brand Management
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_modules');
    }
};