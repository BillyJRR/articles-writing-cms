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
        Schema::create('draft_category', function (Blueprint $table) {
            $table->foreignId('draft_id');
            $table->foreignId('category_id');
            $table->foreign('draft_id')->references('id')->on('drafts');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->primary(['draft_id', 'category_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('draft_category');
    }
};
