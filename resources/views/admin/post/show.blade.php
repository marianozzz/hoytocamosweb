@extends('layouts.admin')

@section('title', 'Ver post — Admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h1 class="h3 fw-bold mb-1">Detalle del post</h1>
            <p class="text-muted mb-0">Vista previa de cómo se verá la noticia.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-secondary rounded-pill">
                <i class="bi bi-arrow-left me-1"></i> Volver
            </a>
            <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-dark rounded-pill">
                <i class="bi bi-pencil me-1"></i> Editar
            </a>
        </div>
    </div>

    <div class="row g-4">
        {{-- Columna principal --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 p-lg-5">

                    {{-- Estado y fecha --}}
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        @if ($post->published)
                            <span class="badge rounded-pill bg-success">Publicado</span>
                        @else
                            <span class="badge rounded-pill bg-secondary">Borrador</span>
                        @endif
                        <span class="badge rounded-pill bg-light text-dark border">
                            <i class="bi bi-calendar3 me-1"></i>
                            {{ $post->published_at?->format('d/m/Y H:i') ?? 'Sin fecha' }}
                        </span>
                    </div>

                    {{-- Título --}}
                    <h1 class="h2 fw-bold mb-3">{{ $post->title }}</h1>

                    {{-- Autor y slug --}}
                    <p class="text-muted small mb-4">
                        Por <strong>{{ $post->user->name }}</strong> ·
                        <code>{{ $post->slug }}</code>
                    </p>

                    {{-- Portada --}}
                    @if ($post->coverUrl())
                        <div class="mb-4">
                            <img src="{{ $post->coverUrl() }}"
                                 alt="{{ $post->title }}"
                                 class="img-fluid rounded-4 shadow-sm w-100"
                                 style="max-height: 400px; object-fit: cover;">
                        </div>
                    @endif

                    {{-- Extracto --}}
                    @if ($post->excerpt)
                        <p class="lead text-muted mb-4">{{ $post->excerpt }}</p>
                    @endif

                    {{-- Cuerpo --}}
                    <article class="post-body">
                        {!! $post->body !!}
                    </article>

                </div>
            </div>
        </div>

        {{-- Columna lateral --}}
        <div class="col-lg-4">
            {{-- Información --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">
                        <i class="bi bi-info-circle me-1" style="color: var(--ht-magenta);"></i>
                        Información
                    </h6>
                    <ul class="list-unstyled small mb-0">
                        <li class="d-flex justify-content-between mb-2">
                            <span class="text-muted">ID</span>
                            <span class="fw-semibold">#{{ $post->id }}</span>
                        </li>
                        <li class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Creado</span>
                            <span class="fw-semibold">{{ $post->created_at->format('d/m/Y H:i') }}</span>
                        </li>
                        <li class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Actualizado</span>
                            <span class="fw-semibold">{{ $post->updated_at->format('d/m/Y H:i') }}</span>
                        </li>
                        <li class="d-flex justify-content-between">
                            <span class="text-muted">Autor</span>
                            <span class="fw-semibold">{{ $post->user->name }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Acciones --}}
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">
                        <i class="bi bi-gear me-1" style="color: var(--ht-cyan);"></i>
                        Acciones
                    </h6>
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-dark rounded-pill">
                            <i class="bi bi-pencil me-1"></i> Editar post
                        </a>
                        <a href="{{ route('posts.show', $post->slug) }}" target="_blank"
                           class="btn btn-outline-secondary rounded-pill">
                            <i class="bi bi-box-arrow-up-right me-1"></i> Ver en el sitio
                        </a>
                        <form method="POST" action="{{ route('admin.posts.destroy', $post) }}"
                              onsubmit="return confirm('¿Eliminar este post? Esta acción no se puede deshacer.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger rounded-pill w-100">
                                <i class="bi bi-trash me-1"></i> Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection