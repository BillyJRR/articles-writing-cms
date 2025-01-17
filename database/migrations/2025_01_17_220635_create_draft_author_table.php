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
        Schema::create('draft_author', function (Blueprint $table) {
            $table->foreignId('draft_id');
            $table->foreignId('author_id');
            $table->foreign('draft_id')->references('id')->on('drafts');
            $table->foreign('author_id')->references('id')->on('authors');
            $table->primary(['draft_id', 'author_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('draft_author');
    }
};
