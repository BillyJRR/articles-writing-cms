<?php

namespace App\Services;

use App\Models\Article;
use App\Models\Draft;
use App\Repositories\ArticleRepository;
use App\Repositories\DraftRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DraftService
{
    private $draftRepository;
    private $articleRepository;

    public function __construct(DraftRepository $draftRepository, ArticleRepository $articleRepository) {
        $this->draftRepository = $draftRepository;
        $this->articleRepository = $articleRepository;
    }

    public function createUpdate(Request $request)
    {
        $data = $request->all();
        if ($data['draft_id']) {
            $draft = Draft::find($data['draft_id']);
            if ($request->hasFile('image')) {
                if ($draft->image) {
                    Storage::disk('public')->delete($draft->image);
                }
                $data['image'] = $request->file('image')->store('articles', 'public');
            }
            $this->draftRepository->update($data, $draft);
        } else {
            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('articles', 'public');
            }
            $data['status'] = 0;
            $data['status_text'] = Draft::STATUS_TEXT[0];
            $data['article_id'] = null;
            $this->draftRepository->create($data);
        }
    }

    public function delete($draftId)
    {
        $draft = Draft::find($draftId);
        $this->draftRepository->delete($draft->id);
        $this->articleRepository->delete($draft->article_id);

    }

    public function postDraft($draftId, $type)
    {
        $draft = Draft::with('authors', 'categories')->where('id', $draftId)->first()->toArray();
        $draft['user_id'] = 1;
       
        $categoryIds = array_map(function ($category) {
            return $category['id'];
        }, $draft['categories']);

        $draft['categories'] = $categoryIds;

        $authorIds = array_map(function ($author) {
            return $author['id'];
        }, $draft['authors']);

        $draft['authors'] = $authorIds;

        if ($type == 1) {
            $draft['status'] = 1;
            $draft['status_text'] = Draft::STATUS_TEXT[1];

            $article = $this->articleRepository->create($draft);

            if ($article) {
                $data['article_id'] = $article->id;
                $data['status'] = 1;
                $data['status_text'] = Draft::STATUS_TEXT[1];
                $this->draftRepository->updateStatus($data, $draftId);
            }
        } else {
            $article = Article::find($draft['article_id']);
            $this->articleRepository->update($draft, $article);
        }
    }
}