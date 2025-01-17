<?php

namespace App\Services;

use App\Models\Article;
use App\Repositories\ArticleRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticleService
{
    private $articleRepository;

    public function __construct(ArticleRepository $articleRepository) {
        $this->articleRepository = $articleRepository;
    }

    public function findBySlug(string $category, string $title)
    {
        return $this->articleRepository->findBySlug($category, $title);
    }

    public function create(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = 1;
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('articles', 'public');
        }
        $data['status'] = 0;
        $data['status_text'] = Article::STATUS_TEXT[0];
        
        $this->articleRepository->create($data);
    }

    public function update(Request $request, Article $article)
    {
        $data = $request->all();
        $data['user_id'] = 1;
        if ($request->hasFile('image')) {
            if ($article->image) {
                Storage::disk('public')->delete($article->image);
            }
            $data['image'] = $request->file('image')->store('articles', 'public');
        }
        $data['status_text'] = Article::STATUS_TEXT[$article->status];
        $data['slug'] = $article->status ? $article->slug : $data['slug'];

        $this->articleRepository->update($data, $article);
    }

    public function delete($articleId)
    {
        $this->articleRepository->delete($articleId);
    }
    
    public function updateStatus(Request $request, $articleId)
    {
        $data = $request->only('status');
        $this->articleRepository->updateStatus($data, $articleId);
    }
}