@extends('layout.app')
@section('content')
<div class="mx-4">
    <div class="d-flex align-items-center justify-content-between">
        <h1 class="content__title"><u>Borradores</u></h1>
        <a href="{{ route('drafts.new') }}" class="btn btn-success mx-5">Nuevo</a>
    </div>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>N°</th>
                <th>Titulo</th>
                <th>Autor</th>
                <th>Descripción</th>
                <th colspan="5" class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($drafts as $key => $draft) {?>
            <tr>
                <td>{{ ($drafts->currentPage() - 1) * $drafts->perPage() + $key + 1 }}</td>
                <td>{{ $draft->title }}</td>
                <td>{{ implode(', ', $draft->authors->pluck('name')->toArray()) }}</td>
                <td>{{ substr($draft->body, 0, 100) }}...</td>
                {{-- <td>
                    <input type="checkbox" class="btn-check" id="switchDefault-{{ $draft->id }}" onclick="updateStatusText({{ $draft->id }})" {{ isset($draft) ? ($draft->status == 1 ? 'checked' : '') : '' }}>
                    <label class="btn btn-primary" for="switchDefault-{{ $draft->id }}" id="statusLabel-{{ $draft->id }}">{{ $draft->status == 1 ? 'Publicado' : 'Despublicado' }}</label>
                </td> --}}
                <td><a href="{{ route('drafts.create', ['draft' => $draft]) }}" class="btn btn-info">Guardar nota</a></td>
                <td><button type="button" class="btn btn-info" onclick="postDraft({{ $draft->id }}, 1)" @if($draft->status == 1) disabled @endif>Publicar nota</button></td>
                <td><a href="{{ route('drafts.edit', ['draft' => $draft]) }}" class="btn btn-info">Editar nota</a></td>
                <td><button type="button" class="btn btn-info" onclick="postDraft({{ $draft->id }}, 2)" @if($draft->status == 0) disabled @endif>Publicar actualización de la nota</button></td>
                <td><button type="button" class="btn btn-danger" onclick="deleteDraft({{ $draft->id }})">Eliminar</button></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <div class="content__pagination">
        {{ $drafts->links() }}
    </div>
</div>
@endsection
@section('scripts')
<script>
function updateStatusText(draftId) {
    let checkbox = document.getElementById(`switchDefault-${draftId}`);
    let label = document.getElementById(`statusLabel-${draftId}`);
    let status = checkbox.checked ? 1 : 0;
    label.textContent = status ? 'Publicado' : 'Despublicado';

    const data = {
        status: status
    };

    fetch(`/admin-cms/drafts/${draftId}/status`, {
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

function deleteDraft(draftId) {
    fetch(`/admin-cms/drafts/${draftId}`, {
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

function postDraft(draftId, type) {
    fetch(`/admin-cms/drafts/post/draft/${draftId}/${type}`, {
        method: "PATCH",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        }
    }).then(response => {
        if (!response.ok) {
            throw new Error('Error al publicar el articulo');
        }
        return response.json();
    }).then(data => {
        alert(data.message);
        location.reload();
    }).catch(error => {
        console.error('Error:', error);
        alert('Hubo un error al publicar el articulo.');
    });
}
</script>
@endsection