@extends('layouts.app')

@section('title', 'Noticias — HoyTocamos')

@section('content')
    <div class="container py-5">

        {{-- Cabecera --}}
        <div class="mb-5">
            <h1 class="display-5 fw-bold mb-2">Noticias de la escena</h1>
            <p class="text-muted mb-0">Novedades, convocatorias y espacios nuevos de la comunidad.</p>
        </div>

        {{-- Listado de posts --}}
        @if ($posts->isEmpty())
            <div class="ht-news text-center py-5">
                <i class="bi bi-journal-x fs-1 text-muted"></i>
                <p class="text-muted mt-3 mb-0">Aún no hay noticias publicadas.</p>
            </div>
        @else
            <div class="row g-4">
                @foreach ($posts as $post)
                    <div class="col-md-6 col-lg-4">
                        <article class="ht-card h-100 d-flex flex-column">
                            @if ($post->coverUrl())
                                <img src="{{ $post->coverUrl() }}"
                                     alt="{{ $post->title }}"
                                     class="card-img-top"
                                     style="height: 180px; object-fit: cover;">
                            @endif

                            <div class="card-body p-4 d-flex flex-column">
                                <span class="ht-date-badge mb-2">
                                    {{ $post->published_at?->format('d M Y') }}
                                </span>
                                <h5 class="fw-bold mt-2 mb-2">{{ $post->title }}</h5>
                                <p class="text-muted small mb-3">
                                    {{ $post->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($post->body), 120) }}
                                </p>

                                <div class="mt-auto">
                                    <a href="{{ route('posts.show', $post->slug) }}"
                                       class="small fw-semibold text-decoration-none"
                                       style="color: var(--ht-magenta);">
                                        Leer más <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>

            {{-- Paginación --}}
            <div class="mt-5 d-flex justify-content-center">
                {{ $posts->links() }}
            </div>
        @endif

    </div>
@endsection