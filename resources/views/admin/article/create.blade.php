@extends('layout.app')
@section('content')
<div class="mx-4">
    <div class="d-flex align-items-center justify-content-between">
        <h1>{{ isset($article) ? 'Editar Artículo' : 'Crear Artículo' }}</h1>
    </div>

    <form class="row g-3" action="{{ isset($article) ? route('articles.update', ['article' => $article]) : route('articles.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($article))
            @method('PUT')
        @endif
        <div class="col-md-6">
            <label class="form-label" for="title">Título:</label>
            <input id="title" type="text" class="form-control" name="title" value="{{ $article->title ?? '' }}" oninput="generateSlug()" required>
        </div>
        <div class="col-md-6">
            <label class="form-label" for="slug">Slug:</label>
            <input id="slug" type="text" class="form-control" name="slug" value="{{ $article->slug ?? '' }}" readonly>
        </div>
        <div class="col-md-6">
            <label class="form-label" for="body">Descripción:</label>
            <textarea id="body" class="form-control" name="body">{{ $article->body ?? '' }}</textarea>
        </div>
        <div class="col-md-6">
            <label class="form-label" for="inputGroupSelect01">Autores</label>
            <select class="form-select" id="inputGroupSelect01" name="author_id" required>
                <option selected disabled value="">Seleccione un autor</option>
                @foreach($authors as $author)
                    @if (isset($article))
                    <option option value={{ $author->id }} @if($author->id == $article->author_id) selected @endif>{{ $author->name }}</option>
                    @else
                    <option option value={{ $author->id }}>{{ $author->name }}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label" for="category">Categorías</label>
            <select class="form-select" id="category" multiple name="categories[]" onchange="updateCategorySelection(event)" required>
                @foreach($categories as $category)
                    @if (isset($article))
                    <option value="{{ $category->id }}" @if(in_array($category->id, $article->categories->pluck('id')->toArray())) selected @endif>{{ $category->name }}</option>
                    @else
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label" for="image">Imagen:</label>
            <input type="file" class="form-control" name="image" accept=".png, .jpg, .jpeg, .svg">
            @if(isset($article) && $article->image)
            <div class="py-2">
                <label class="form-label" for="image">Imagen actual:</label>
                <img src="{{ asset('storage')."/".$article->image }}" alt="Imagen actual" width="150">
            </div>
            @endif
        </div>
        <input id="status" type="number" value="{{$article->status ?? ''}}" hidden />
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        @if($errors->has('categories'))
            <div class="alert alert-danger">
                {{ $errors->first('categories') }}
            </div>
        @endif
        @if($errors->has('image'))
            <div class="alert alert-danger">
                {{ $errors->first('image') }}
            </div>
        @endif
        <div class="col-md-12 text-center pt-4">
            <button type="submit" class="btn btn-success">{{ isset($article) ? 'Actualizar' : 'Crear' }}</button>
        </div>
    </form>
</div>
@endsection
@section('scripts')
<script>

let selectedCategories = [];

function slugify(text) {
    return text.toString().toLowerCase()
        .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
        .trim()
        .replace(/\s+/g, '-')
        .replace(/&/g, '-and-')
        .replace(/[^\w\-]+/g, '')
        .replace(/\-\-+/g, '-');
}

function updateCategorySelection(event) {
    const selectedOptions = Array.from(event.target.options);
    
    selectedOptions.forEach(option => {
        if (option.selected && !selectedCategories.includes(option.text)) {
            selectedCategories.push(option.text);
        } else if (!option.selected && selectedCategories.includes(option.text)) {
            selectedCategories = selectedCategories.filter(e => e !== option.text);
        }
    });
    generateSlug();
}

function generateSlug() {
    let status = document.getElementById('status').value;
    let title = document.getElementById('title').value;
    let firstCategory = selectedCategories.length > 0 ? selectedCategories[0] : "";
    let slugCategory = slugify(firstCategory);
    let slugTitle = slugify(title);

    if (status == 0) {
        document.getElementById('slug').value = slugCategory ? `${slugCategory}/${slugTitle}` : slugTitle;
    }
}
</script>
@endsection