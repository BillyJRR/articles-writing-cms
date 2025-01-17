@extends('layout.app')
@section('content')
<div class="content">
    <h1 class="content__title"><u>{{ $detail->title }}</u></h1>
    <h2 class="text-center">Autor: {{ $detail->author->name }}</h2>
    <div class="content__body">
        <div class="d-flex gap-2">
            <h5>Categorías:</h5>
            <span>{{ implode(', ', $detail->categories->pluck('name')->toArray()) }}</span>
        </div>
        <p class="card-text">{{ $detail->body }}</p>
        <div class="d-flex align-items-center justify-content-center">
            <img src="{{ asset('storage')."/".$detail->image }}" class="article-image" alt="{{ $detail->title }}">
        </div>
    </div>
</div>
@endsection