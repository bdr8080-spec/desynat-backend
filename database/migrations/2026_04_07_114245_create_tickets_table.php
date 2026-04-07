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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_id');
            
            $table->foreignId('ticket_type_id')
                  ->constrained('ticket_types')
                  ->onDelete('cascade');
            
            $table->string('title');
            $table->text('description');
            
            $table->unsignedBigInteger('sender_id');
            $table->tinyInteger('sender_type')
                  ->comment('1-user,2-seller,3-affiliate,4-driver');
            
            $table->string('file')->nullable();
            
            $table->tinyInteger('status')
                  ->default(0)
                  ->comment('0-pending,1-resolved');
            
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};