<?php

namespace App\Repositories;

use App\Models\Article;
use App\Models\Category;

class ArticleRepository
{
    public function findBySlug(string $category, string $title)
    {
        $slug = $category."/".$title;
        return Article::with('author', 'categories')->where('slug', $slug)->where('status', 1)->first();
    }

    public function create(array $attrs)
    {
        $article = Article::create($attrs);
        $categories = Category::whereIn('id', $attrs['categories'])->pluck('id');
        $article->categories()->attach($categories);
    }

    public function update(array $attrs, Article $article)
    {
        $article->update($attrs);
        $categories = Category::whereIn('id', $attrs['categories'])->pluck('id');
        $article->categories()->sync($categories);
    }

    public function delete($articleId)
    {
        $article = Article::find($articleId);
        $article->delete();
    }

    public function updateStatus(array $attrs, $articleId)
    {
        $article = Article::find($articleId);
        $article->update($attrs);
    }
}