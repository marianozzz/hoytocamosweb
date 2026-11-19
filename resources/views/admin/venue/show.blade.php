@extends('layouts.admin')

@section('title', 'Ver lugar — Admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h1 class="h3 fw-bold mb-1">Detalle del lugar</h1>
            <p class="text-muted mb-0">Vista previa de cómo se verá el espacio en el sitio.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.venues.index') }}" class="btn btn-outline-secondary rounded-pill">
                <i class="bi bi-arrow-left me-1"></i> Volver
            </a>
            <a href="{{ route('admin.venues.edit', $venue) }}" class="btn btn-dark rounded-pill">
                <i class="bi bi-pencil me-1"></i> Editar
            </a>
        </div>
    </div>

    <div class="row g-4">
        {{-- Columna principal --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 p-lg-5">

                    {{-- Portada --}}
                    @if ($venue->coverUrl())
                        <div class="mb-4">
                            <img src="{{ $venue->coverUrl() }}"
                                 alt="{{ $venue->name }}"
                                 class="img-fluid rounded-4 shadow-sm w-100"
                                 style="max-height: 400px; object-fit: cover;">
                        </div>
                    @endif

                    {{-- Título --}}
                    <h1 class="h2 fw-bold mb-3">{{ $venue->name }}</h1>

                    {{-- Slug --}}
                    <p class="text-muted small mb-4">
                        <code>{{ $venue->slug }}</code>
                    </p>

                    {{-- Descripción --}}
                    @if ($venue->description)
                        <article class="post-body">
                            {!! nl2br(e($venue->description)) !!}
                        </article>
                    @endif

                </div>
            </div>

            {{-- Galería --}}
            @if ($venue->galleryUrls())
                <div class="card border-0 shadow-sm mt-4">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3">
                            <i class="bi bi-images me-1" style="color: var(--ht-cyan);"></i>
                            Galería
                        </h6>
                        <div class="row g-3">
                            @foreach ($venue->galleryUrls() as $url)
                                <div class="col-md-4">
                                    <img src="{{ $url }}" alt="Imagen de {{ $venue->name }}"
                                         class="img-fluid rounded-3 w-100"
                                         style="height: 160px; object-fit: cover;">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>

        {{-- Columna lateral --}}
        <div class="col-lg-4">
            {{-- Ubicación --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">
                        <i class="bi bi-geo-alt me-1" style="color: var(--ht-magenta);"></i>
                        Ubicación
                    </h6>
                    <ul class="list-unstyled small mb-0">
                        <li class="mb-2">
                            <span class="text-muted d-block">Dirección</span>
                            <span class="fw-semibold">{{ $venue->address ?? 'Sin definir' }}</span>
                        </li>
                        <li class="mb-2">
                            <span class="text-muted d-block">Ciudad</span>
                            <span class="fw-semibold">{{ $venue->city?->name ?? 'Sin definir' }}</span>
                        </li>
                        <li class="mb-2">
                            <span class="text-muted d-block">Provincia</span>
                            <span class="fw-semibold">{{ $venue->city?->province?->name ?? 'Sin definir' }}</span>
                        </li>
                        <li>
                            <span class="text-muted d-block">País</span>
                            <span class="fw-semibold">{{ $venue->city?->province?->country?->name ?? 'Sin definir' }}</span>
                        </li>
                    </ul>

                    @if ($venue->latitude && $venue->longitude)
                        <hr>
                        <div class="small">
                            <span class="text-muted d-block">Coordenadas</span>
                            <span class="fw-semibold">
                                {{ $venue->latitude }}, {{ $venue->longitude }}
                            </span>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Redes sociales --}}
            @if ($venue->socialLinks->count() > 0)
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3">
                            <i class="bi bi-share me-1" style="color: var(--ht-magenta);"></i>
                            Redes sociales
                        </h6>
                        <div class="d-flex flex-column gap-2">
                            @foreach ($venue->socialLinks as $link)
                                <a href="{{ $link->url }}" target="_blank"
                                   class="d-flex align-items-center gap-2 text-decoration-none text-dark p-2 border rounded-3">
                                    <i class="bi {{ $link->socialPlatform->icon ?? 'bi-share' }} fs-5"></i>
                                    <div class="small text-truncate">
                                        <div class="fw-semibold">{{ $link->socialPlatform->name }}</div>
                                        <div class="text-muted text-truncate">{{ $link->url }}</div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            {{-- Información --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">
                        <i class="bi bi-info-circle me-1" style="color: var(--ht-cyan);"></i>
                        Información
                    </h6>
                    <ul class="list-unstyled small mb-0">
                        <li class="d-flex justify-content-between mb-2">
                            <span class="text-muted">ID</span>
                            <span class="fw-semibold">#{{ $venue->id }}</span>
                        </li>
                        <li class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Creado</span>
                            <span class="fw-semibold">{{ $venue->created_at->format('d/m/Y H:i') }}</span>
                        </li>
                        <li class="d-flex justify-content-between">
                            <span class="text-muted">Actualizado</span>
                            <span class="fw-semibold">{{ $venue->updated_at->format('d/m/Y H:i') }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Acciones --}}
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">
                        <i class="bi bi-gear me-1" style="color: #b8a400;"></i>
                        Acciones
                    </h6>
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.venues.edit', $venue) }}" class="btn btn-dark rounded-pill">
                            <i class="bi bi-pencil me-1"></i> Editar lugar
                        </a>
                        <form method="POST" action="{{ route('admin.venues.destroy', $venue) }}"
                              onsubmit="return confirm('¿Eliminar este lugar? Esta acción no se puede deshacer.');">
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