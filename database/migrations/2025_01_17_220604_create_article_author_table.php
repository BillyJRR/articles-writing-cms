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
        Schema::create('article_author', function (Blueprint $table) {
            $table->foreignId('article_id');
            $table->foreignId('author_id');
            $table->foreign('article_id')->references('id')->on('articles');
            $table->foreign('author_id')->references('id')->on('authors');
            $table->primary(['article_id', 'author_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_author');
    }
};
