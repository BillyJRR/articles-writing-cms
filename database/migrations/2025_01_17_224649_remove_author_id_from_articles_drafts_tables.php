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
        Schema::table('articles', function (Blueprint $table) {
            $table->dropForeign('articles_author_id_foreign');
            $table->foreignId('author_id')->nullable()->change();
        });

        Schema::table('drafts', function (Blueprint $table) {
            $table->dropForeign('drafts_author_id_foreign');
            $table->foreignId('author_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->foreign('author_id')->references('id')->on('authors');
            $table->foreignId('author_id')->nullable(false)->change();
        });

        Schema::table('drafts', function (Blueprint $table) {
            $table->foreign('author_id')->references('id')->on('authors');
            $table->foreignId('author_id')->nullable(false)->change();
        });
    }
};
