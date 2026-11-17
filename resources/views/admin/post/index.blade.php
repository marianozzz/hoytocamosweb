@extends('layouts.admin')

@section('title', 'Blog — Admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h1 class="h3 fw-bold mb-1">Blog</h1>
            <p class="text-muted mb-0">Gestiona las noticias y novedades de HoyTocamos.</p>
        </div>
        <a href="{{ route('admin.posts.create') }}" class="btn btn-dark rounded-pill">
            <i class="bi bi-plus-lg me-1"></i> Nuevo post
        </a>
    </div>

    {{-- Mensaje de éxito --}}
    @if (session('status'))
        <div class="alert alert-success rounded-3" role="alert">
            <i class="bi bi-check-circle me-1"></i> {{ session('status') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            @if ($posts->isEmpty())
                <div class="text-center py-5">
                    <i class="bi bi-journal-x fs-1 text-muted"></i>
                    <p class="text-muted mt-3 mb-0">Aún no hay posts publicados.</p>
                    <p class="text-muted small">Crea el primero con el botón "Nuevo post".</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Título</th>
                                <th>Autor</th>
                                <th>Estado</th>
                                <th>Fecha</th>
                                <th class="text-end pe-4">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($posts as $post)
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-semibold">{{ $post->title }}</div>
                                        <div class="text-muted small">{{ $post->slug }}</div>
                                    </td>
                                    <td>{{ $post->user->name }}</td>
                                    <td>
                                        @if ($post->published)
                                            <span class="badge rounded-pill bg-success">Publicado</span>
                                        @else
                                            <span class="badge rounded-pill bg-secondary">Borrador</span>
                                        @endif
                                    </td>
                                    <td class="text-muted small">
                                        {{ $post->published_at?->format('d/m/Y') ?? $post->created_at->format('d/m/Y') }}
                                    </td>
                                    <td class="text-end pe-4">
                                        <a href="{{ route('admin.posts.show', $post) }}"
                                           class="btn btn-sm btn-outline-secondary rounded-pill" title="Ver">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.posts.edit', $post) }}"
                                           class="btn btn-sm btn-outline-primary rounded-pill" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.posts.destroy', $post) }}"
                                              class="d-inline" onsubmit="return confirm('¿Eliminar este post?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill" title="Eliminar">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Paginación --}}
                <div class="p-3 border-top">
                    {{ $posts->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection