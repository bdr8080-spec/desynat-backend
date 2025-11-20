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
        Schema::create('delivery_boy_documents', function (Blueprint $table) {
            $table->id();

            $table->foreignId('delivery_boy_id')
                ->constrained('delivery_boys')
                ->onDelete('cascade');

            $table->enum('document_type', ['1','2','3','4','5','6'])
                ->comment('1-vehicle image 2-identity proof 3-driving license 4-vehicle insurance 5-pollution paper 6-registration certificate');

            $table->string('document_path');

            $table->tinyInteger('is_front')
                ->default(0)
                ->comment('0-no 1-yes');

            $table->tinyInteger('status')
                ->default(1)
                ->comment('0-inactive 1-active');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_boy_documents');
    }
};
