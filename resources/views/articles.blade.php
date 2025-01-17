@extends('layout.app')
@section('content')
    <div class="content">
        <h1 class="content__title"><u>Articulos</u></h1>
        <div class="content__body">
            <?php foreach ($articles as $key => $value) { ?>
            <div class="card">
                <img src="{{ asset('storage')."/".$value->image }}" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">{{ $value->title }}</h5>
                    <p class="card-text">{{  substr($value->body, 0, 100) }} ...</p>
                    <?php $separate = explode("/",$value->slug) ?>
                    <a href="{{route('detail', ['category' => $separate[0], 'title' => $separate[1]])}}" class="btn btn-primary">Leer más</a>
                </div>
            </div>
            <?php } ?>
        </div>
        <div class="content__pagination">
            {{ $articles->links() }}
        </div>
    </div>
@endsection