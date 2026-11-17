@extends('layouts.app')

@section('title', $post->title . ' — HoyTocamos')

@section('content')
    <div class="container py-5">

        {{-- Volver al listado --}}
        <a href="{{ route('posts.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill mb-4">
            <i class="bi bi-arrow-left me-1"></i> Volver a noticias
        </a>

        <div class="row justify-content-center">
            <div class="col-lg-8">

                {{-- Cabecera del post --}}
                <header class="mb-4">
                    <span class="ht-date-badge mb-3">
                        {{ $post->published_at?->format('d M Y') }}
                    </span>
                    <h1 class="display-5 fw-bold mt-3 mb-3">{{ $post->title }}</h1>
                    <p class="text-muted mb-0">
                        Publicado por <strong>{{ $post->user->name }}</strong>
                    </p>
                </header>

                {{-- Portada --}}
                @if ($post->coverUrl())
                    <div class="mb-4">
                        <img src="{{ $post->coverUrl() }}"
                             alt="{{ $post->title }}"
                             class="img-fluid rounded-4 shadow-sm w-100"
                             style="max-height: 420px; object-fit: cover;">
                    </div>
                @endif

                {{-- Extracto --}}
                @if ($post->excerpt)
                    <p class="lead text-muted mb-4">{{ $post->excerpt }}</p>
                @endif

                {{-- Cuerpo del post (HTML de TinyMCE) --}}
                <article class="ht-card p-4 p-lg-5">
                    <div class="post-body">
                        {!! $post->body !!}
                    </div>
                </article>

                {{-- Footer del post --}}
                <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-2">
                    <a href="{{ route('posts.index') }}" class="btn btn-outline-secondary rounded-pill">
                        <i class="bi bi-arrow-left me-1"></i> Más noticias
                    </a>
                    <span class="text-muted small">
                        Actualizado {{ $post->updated_at->diffForHumans() }}
                    </span>
                </div>

            </div>
        </div>

    </div>
@endsection