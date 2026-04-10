<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('stories_comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('story_id');
            $table->tinyInteger('user_type')->default(1)->comment('1-admin, 2-user');
            $table->unsignedBigInteger('user_id');
            $table->text('comment');
            $table->tinyInteger('status')->default(1)->comment('0-inactive, 1-active');
            $table->timestamps();

            // Foreign key (assuming stories table exists)
            $table->foreign('story_id')
                  ->references('id')
                  ->on('stories')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stories_comments');
    }
};
