<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostArticleRequest;
use App\Models\Category;
use App\Services\ArticleService;
use App\Services\PostArticleService;
use Illuminate\Http\Response;
use Exception;
use Illuminate\Support\Str;

class PostArticleController extends Controller
{
    private $postArticleService;
    private $articleService;

    public function __construct(PostArticleService $postArticleService, ArticleService $articleService) {
        $this->postArticleService = $postArticleService;
        $this->articleService = $articleService;
    }

    public function store(StorePostArticleRequest $request)
    {
        try {
            $category = Category::find($request->categories[0]);

            $categoryName = Str::slug($category->name);
            $title = Str::slug($request->title);
            $article = $this->articleService->findBySlug($categoryName, $title);
            
            if ($article) {
                $return = [
                    'message' => 'El slug ya existe, favor de modificar el título o categoría, slug actual: '.$article->slug
                ];
                $status = Response::HTTP_BAD_REQUEST;
            } else {
                $result = $this->postArticleService->create($request);
                $return = [
                    'message' => 'Articulo publicado',
                    'data' => $result
                ];
                $status =  Response::HTTP_OK;
            }
        } catch (Exception $e) {
            $return = [
                'message' => 'Ocurrió un error'
            ];
            $status = Response::HTTP_BAD_REQUEST;
        }
        return response()->json($return, $status);
    }
}
