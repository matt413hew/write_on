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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('image');
            $table->string('title');
            $table->string('link');
            $table->timestamp('date');
            $table->longText('content');
            $table->unsignedBigInteger('status');
            $table->unsignedBigInteger('writer');
            $table->unsignedBigInteger('editor');
            $table->unsignedBigInteger('company');
            $table->timestamps();
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
