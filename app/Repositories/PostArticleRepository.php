<?php

namespace App\Repositories;

use App\Models\Article;
use App\Models\Draft;

class PostArticleRepository
{
    public function create(array $attrs)
    {
        $article = Article::create($attrs);
        $article->categories()->attach($attrs['categories']);
        $article->authors()->attach($attrs['authors']);
        
        if ($article) {
            $attrs['article_id'] = $article->id;

            $draft = Draft::create($attrs);
            $draft->categories()->attach($attrs['categories']);
            $draft->authors()->attach($attrs['authors']);
        }

        return $article;
    }
}