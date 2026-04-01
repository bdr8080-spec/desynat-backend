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
        Schema::create('whislist_reels', function (Blueprint $table) {
            $table->id();

            // Foreign keys
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            $table->foreignId('reel_id')
                  ->constrained('reels')
                  ->onDelete('cascade');

            // Status: 1-active, 0-inactive
            $table->tinyInteger('status')
                  ->default(1)
                  ->comment('1-active, 0-inactive');

            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('whislist_reels');
    }
};