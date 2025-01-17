<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDraftRequest;
use App\Http\Requests\UpdateDraftRequest;
use App\Models\Author;
use App\Models\Category;
use App\Models\Draft;
use App\Services\DraftService;
use Exception;
use Illuminate\Support\Facades\Log;

class DraftController extends Controller
{
    private $draftService;

    public function __construct(DraftService $draftService) {
        $this->draftService = $draftService;
    }

    public function datatable()
    {
        $drafts = Draft::select('id', 'title', 'author_id', 'body', 'status')->with('authors:id,name')->paginate(request('per_page', 10));
        
        return view('admin.draft.index', compact('drafts'));
    }

    public function new()
    {
        $authors = Author::select('id', 'name')->get();
        $categories = Category::select('id', 'name')->get();
    
        return view('admin.draft.create', compact('authors', 'categories'));
    }

    public function create(Draft $draft)
    {
        $authors = Author::select('id', 'name')->get();
        $categories = Category::select('id', 'name')->get();
    
        return view('admin.draft.create', compact('draft', 'authors', 'categories'));
    }

    public function store(StoreDraftRequest $request)
    {
        try {
            $this->draftService->createUpdate($request);
        
            return redirect()->route('drafts.index');
        } catch (Exception $e) {
            Log::error('Error al crear artículo: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al crear el artículo');
        }
    }

    public function edit(Draft $draft)
    {
        $authors = Author::select('id', 'name')->get();
        $categories = Category::select('id', 'name')->get();

        return view('admin.draft.edit', compact('draft', 'authors', 'categories'));
    }

    public function update(UpdateDraftRequest $request, Draft $draft)
    {
        try {
            $this->draftService->createUpdate($request, $draft);
    
            return redirect()->route('drafts.index');
        } catch (Exception $e) {
            Log::error('Error al actualizar el borrador: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Hubo un error al actualizar el borrador. Intente nuevamente.');
        }
    }

    public function destroy($draftId)
    {
        try {
            $this->draftService->delete($draftId);
            return response()->json([
                'message' => 'Articulo eliminado con éxito'
            ]);
        } catch (Exception $e) {
            Log::error('Error al eliminar artículo: ' . $e->getMessage());
            return response()->json(['error' => 'No se pudo eliminar el artículo'], 500);
        }
    }

    public function postDraft($draftId, $type)
    {
        try {
            $this->draftService->postDraft($draftId, $type);
            return response()->json([
                'message' => 'Borrador publicado con éxito'
            ]);
        } catch (Exception $e) {
            Log::error('Error al publicar el borrador: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Hubo un error al publicar el borrador. Intente nuevamente.');
        }
    }
}
