<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Http\Requests\UpdateStatusArticleRequest;
use App\Models\Article;
use App\Models\Author;
use App\Models\Category;
use App\Services\ArticleService;
use Exception;
use Illuminate\Support\Facades\Log;

class ArticleController extends Controller
{
    private $articleService;

    public function __construct(ArticleService $articleService) {
        $this->articleService = $articleService;
    }

    public function datatable()
    {
        $articles =  Article::select('id', 'title', 'author_id', 'body', 'status')->with('author:id,name')->paginate(request('per_page', 10));
        
        return view('admin.article.index', compact('articles'));
    }

    public function index()
    {
        $articles =  Article::select('title', 'body', 'slug', 'image')->where('status', 1)->paginate(request('per_page', 9));
        
        return view('articles', compact('articles'));
    }

    public function show($category, $title)
    {
        $detail = $this->articleService->findBySlug($category, $title);
        
        return $detail ? view('article-detail', compact('detail')) : view('error');
    }

    public function create()
    {
        $authors = Author::select('id', 'name')->get();
        $categories = Category::select('id', 'name')->get();
    
        return view('admin.article.create', compact('authors', 'categories'));
    }

    public function store(StoreArticleRequest $request)
    {
        try {
            $this->articleService->create($request);
        
            return redirect()->route('articles.index')->with('success', 'Artículo creado');
        } catch (Exception $e) {
            Log::error('Error al crear artículo: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al crear el artículo');
        }
    }

    public function edit(Article $article)
    {
        $article = $article->load('categories');
        $authors = Author::select('id', 'name')->get();
        $categories = Category::select('id', 'name')->get();

        return view('admin.article.create', compact('article', 'authors', 'categories'));
    }

    public function update(UpdateArticleRequest $request, Article $article)
    {
        try {
            $this->articleService->update($request, $article);
    
            return redirect()->route('articles.index')->with('success', 'Artículo actualizado con éxito');
        } catch (Exception $e) {
            Log::error('Error al actualizar artículo: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Hubo un error al actualizar el artículo. Intente nuevamente.');
        }
    }

    public function destroy($articleId)
    {
        try {
            $this->articleService->delete($articleId);
        
            return response()->json([
                'message' => 'Articulo eliminado con éxito'
            ]);
        } catch (Exception $e) {
            Log::error('Error al eliminar artículo: ' . $e->getMessage());
            return response()->json(['error' => 'No se pudo eliminar el artículo'], 500);
        }
    }

    public function updateStatus(UpdateStatusArticleRequest $request, $articleId)
    {
        $this->articleService->updateStatus($request, $articleId);
        
        return response()->json([
            'message' => 'Estado actualizado correctamente'
        ]);
    }
}
