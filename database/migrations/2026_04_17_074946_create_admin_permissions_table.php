<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admin_permissions', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('admin_id');
            $table->unsignedBigInteger('module_id');

            $table->boolean('can_view')->default(0);
            $table->boolean('can_action')->default(0);

            $table->timestamps();

            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
            $table->foreign('module_id')->references('id')->on('admin_modules')->onDelete('cascade');

            $table->unique(['admin_id', 'module_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_permissions');
    }
};
