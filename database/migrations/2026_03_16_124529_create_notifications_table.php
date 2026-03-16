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
        Schema::create('notifications', function (Blueprint $table) {

            $table->id();

            // Sender
            $table->unsignedBigInteger('sender_id');
            $table->tinyInteger('sender_type')
                  ->comment('1-admin,2-user,3-seller,4-affiliate');

            // Receiver
            $table->unsignedBigInteger('receiver_id');
            $table->tinyInteger('receiver_type')
                  ->comment('1-admin,2-user,3-seller,4-affiliate');

            // Notification content
            $table->string('title_english');
            $table->string('title_arabic');
            $table->text('description_english');
            $table->text('description_arabic');

            $table->string('notification_type')->nullable();

            // Read status
            $table->tinyInteger('is_read')
                  ->default(0)
                  ->comment('0-not read,1-read');

            $table->timestamps();

            // Indexes
            $table->index(['receiver_id','receiver_type']);
            $table->index(['sender_id','sender_type']);

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
