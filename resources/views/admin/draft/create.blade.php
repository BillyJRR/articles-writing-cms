@extends('layout.app')
@section('content')
<div class="mx-4">
    <div class="d-flex align-items-center justify-content-between">
        <h1>Crear Borrador</h1>
    </div>

    <form class="row g-3" action="{{ route('drafts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="col-md-6">
            <label class="form-label" for="title">Título:</label>
            <input id="title" type="text" class="form-control" name="title" value="" oninput="generateSlug()" required>
        </div>
        <div class="col-md-6">
            <label class="form-label" for="slug">Slug:</label>
            <input id="slug" type="text" class="form-control" name="slug" value="" readonly>
        </div>
        <div class="col-md-6">
            <label class="form-label" for="body">Descripción:</label>
            <textarea id="body" class="form-control" name="body"></textarea>
        </div>
        {{-- <div class="col-md-6">
            <label class="form-label" for="inputGroupSelect01">Autores</label>
            <select class="form-select" id="inputGroupSelect01" name="author_id" required>
                <option selected disabled value="">Seleccione un autor</option>
                @foreach($authors as $author)
                <option option value={{ $author->id }}>{{ $author->name }}</option>
                @endforeach
            </select>
        </div> --}}
        <div class="col-md-6">
            <label class="form-label" for="author">Autores</label>
            <select class="form-select" id="author" multiple name="authors[]" required>
                @foreach($authors as $author)
                <option value="{{ $author->id }}">{{ $author->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label" for="category">Categorías</label>
            <select class="form-select" id="category" multiple name="categories[]" onchange="updateCategorySelection(event)" required>
                @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label" for="image">Imagen:</label>
            <input type="file" class="form-control" name="image" accept=".png, .jpg, .jpeg, .svg">
        </div>

        {{-- <input id="status" type="number" value="{{$draft->status ?? ''}}" hidden /> --}}
        <input id="draft_id" type="number" name="draft_id" value="{{$draft->id ?? ''}}" hidden />

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
            <button type="submit" class="btn btn-success">{{ isset($draft) ? 'Actualizar' : 'Crear' }}</button>
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
    // let status = document.getElementById('status').value;
    console.log("STATUS: ",status);
    let title = document.getElementById('title').value;
    let firstCategory = selectedCategories.length > 0 ? selectedCategories[0] : "";
    let slugCategory = slugify(firstCategory);
    let slugTitle = slugify(title);

    document.getElementById('slug').value = slugCategory ? `${slugCategory}/${slugTitle}` : slugTitle;
}
</script>
@endsection