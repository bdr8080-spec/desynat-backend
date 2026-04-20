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
        Schema::create('sellermenu_actions', function (Blueprint $table) {
            $table->id();
            $table->string('seller_id');
            $table->string('menu_id');
            $table->integer('can_view')->default(0)->comment('0 not view 1 view');
            $table->integer('can_action')->default(0)->comment('0 not view 1 view');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sellermenu_actions');
    }
};
