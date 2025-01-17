@extends('layout.app')
@section('content')
<div class="mx-4">
    <div class="d-flex align-items-center justify-content-between">
        <h1 class="content__title"><u>Articulos</u></h1>
        <a href="{{ route('articles.create') }}" class="btn btn-success mx-5">Nuevo</a>
    </div>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>N°</th>
                <th>Titulo</th>
                <th>Autor</th>
                <th>Descripción</th>
                <th colspan="2" class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($articles as $key => $article) {?>
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $article->title }}</td>
                <td>{{ $article->author?->name }}</td>
                <td>{{ substr($article->body, 0, 100) }}...</td>
                <td>
                    <input type="checkbox" class="btn-check" id="switchDefault-{{ $article->id }}" onclick="updateStatusText({{ $article->id }})" {{ isset($article) ? ($article->status == 1 ? 'checked' : '') : '' }}>
                    <label class="btn btn-primary" for="switchDefault-{{ $article->id }}" id="statusLabel-{{ $article->id }}">{{ $article->status == 1 ? 'Publicado' : 'Despublicado' }}</label>
                </td>
                <td><a href="{{ route('articles.edit', ['article' => $article]) }}" class="btn btn-primary">Editar</a></td>
                <td><button type="button" class="btn btn-danger" onclick="deleteArticle({{ $article->id }})">Eliminar</button></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <div class="content__pagination">
        {{ $articles->links() }}
    </div>
</div>
@endsection
@section('scripts')
<script>
function updateStatusText(articleId) {
    let checkbox = document.getElementById(`switchDefault-${articleId}`);
    let label = document.getElementById(`statusLabel-${articleId}`);
    let status = checkbox.checked ? 1 : 0;
    label.textContent = status ? 'Publicado' : 'Despublicado';

    const data = {
        status: status
    };

    fetch(`/admin-cms/articles/${articleId}/status`, {
        method: "PATCH",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify(data)
    }).then(response => {
        if (!response.ok) {
            throw new Error('Error al actualizar el estado');
        }
        return response.json();
    }).then(data => {
        alert(data.message);
    }).catch(error => {
        console.error('Error:', error);
        alert('Hubo un error al actualizar el estado.');
        checkbox.checked = !status;
        label.textContent = !status ? 'Publicado' : 'Despublicado';
    });
}

function deleteArticle(articleId) {
    fetch(`/admin-cms/articles/${articleId}`, {
        method: "DELETE",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
    }).then(response => {
        if (!response.ok) {
            throw new Error('Error al eliminar el articulo');
        }
        return response.json();
    }).then(data => {
        alert(data.message);
        location.reload();
    }).catch(error => {
        console.error('Error:', error);
        alert('Hubo un error al eliminar el articulo.');
    });
}
</script>
@endsection