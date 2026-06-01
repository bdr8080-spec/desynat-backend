<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('story_seen_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('story_id');
            $table->tinyInteger('type')->comment('1-user, 2-seller, 3-admin');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            // indexes (recommended)
            $table->index('story_id');
            $table->index('user_id');
            $table->index('type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('story_seen_histories');
    }
};