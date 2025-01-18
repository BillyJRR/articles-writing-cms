<?php

namespace App\Services;

use App\Models\Article;
use App\Models\Category;
use App\Repositories\PostArticleRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostArticleService
{
    private $postArticleRepository;

    public function __construct(PostArticleRepository $postArticleRepository) {
        $this->postArticleRepository = $postArticleRepository;
    }

    public function create(Request $request)
    {
        $data = $request->all();
        
        $data['slug'] = self::generateSlug($data['categories'][0], $data['title']);
        $data['user_id'] = 1;
        $data['status'] = 1;
        $data['status_text'] = Article::STATUS_TEXT[1];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('articles', 'public');
        }

        return $this->postArticleRepository->create($data);
    }

    public function generateSlug(string $categoryId, string $title)
    {
        $category = Category::find($categoryId);
        $categoryName = Str::slug($category->name);
        $title = Str::slug($title);

        return $categoryName.'/'.$title;
    }
}