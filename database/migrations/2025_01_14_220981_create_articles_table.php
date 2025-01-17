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
            $table->foreignId('user_id');
            $table->foreignId('author_id');
            $table->string('title');
            $table->text('body');
            $table->string('image')->nullable();
            $table->tinyInteger('status');
            $table->string('status_text');
            $table->string('slug')->unique();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('author_id')->references('id')->on('authors');
            $table->timestamps();
            $table->softDeletes();
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
