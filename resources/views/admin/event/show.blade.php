@extends('layouts.admin')

@section('title', 'Ver evento — Admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h1 class="h3 fw-bold mb-1">Detalle del evento</h1>
            <p class="text-muted mb-0">Vista previa de cómo se verá la fecha en el calendario.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.events.index') }}" class="btn btn-outline-secondary rounded-pill">
                <i class="bi bi-arrow-left me-1"></i> Volver
            </a>
            <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-dark rounded-pill">
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
                        @if ($event->published)
                            <span class="badge rounded-pill bg-success">Publicado</span>
                        @else
                            <span class="badge rounded-pill bg-secondary">Borrador</span>
                        @endif

                        @if ($event->eventType)
                            <span class="badge rounded-pill bg-light text-dark border">
                                <i class="bi bi-tag me-1"></i> {{ $event->eventType->name }}
                            </span>
                        @endif

                        <span class="badge rounded-pill bg-light text-dark border">
                            <i class="bi bi-calendar3 me-1"></i>
                            {{ $event->starts_at->format('d/m/Y H:i') }} hs
                        </span>
                    </div>

                    {{-- Título --}}
                    <h1 class="h2 fw-bold mb-3">{{ $event->title }}</h1>

                    {{-- Autor y slug --}}
                    <p class="text-muted small mb-4">
                        Por <strong>{{ $event->user->name }}</strong> ·
                        <code>{{ $event->slug }}</code>
                    </p>

                    {{-- Portada --}}
                    @if ($event->coverUrl())
                        <div class="mb-4">
                            <img src="{{ $event->coverUrl() }}"
                                 alt="{{ $event->title }}"
                                 class="img-fluid rounded-4 shadow-sm w-100"
                                 style="max-height: 400px; object-fit: cover;">
                        </div>
                    @endif

                    {{-- Descripción --}}
                    @if ($event->description)
                        <article class="post-body">
                            {!! $event->description !!}
                        </article>
                    @endif

                </div>
            </div>
        </div>

        {{-- Columna lateral --}}
        <div class="col-lg-4">
            {{-- Lugar y fecha --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">
                        <i class="bi bi-geo-alt me-1" style="color: var(--ht-magenta);"></i>
                        Lugar y fecha
                    </h6>
                    <ul class="list-unstyled small mb-0">
                        <li class="mb-2">
                            <span class="text-muted d-block">Lugar</span>
                            <span class="fw-semibold">{{ $event->venue?->name ?? 'Sin definir' }}</span>
                        </li>
                        <li class="mb-2">
                            <span class="text-muted d-block">Dirección</span>
                            <span class="fw-semibold">{{ $event->address ?? 'Sin definir' }}</span>
                        </li>
                        <li class="mb-2">
                            <span class="text-muted d-block">Ciudad</span>
                            <span class="fw-semibold">{{ $event->city?->name ?? $event->venue?->city?->name ?? 'Sin definir' }}</span>
                        </li>
                        <li class="mb-2">
                            <span class="text-muted d-block">Inicio</span>
                            <span class="fw-semibold">{{ $event->starts_at->format('d/m/Y H:i') }} hs</span>
                        </li>
                        <li>
                            <span class="text-muted d-block">Fin</span>
                            <span class="fw-semibold">
                                {{ $event->ends_at?->format('d/m/Y H:i') ?? 'Sin definir' }}
                                @if ($event->ends_at) hs @endif
                            </span>
                        </li>
                    </ul>
                </div>
            </div>

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
                            <span class="fw-semibold">#{{ $event->id }}</span>
                        </li>
                        <li class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Creado</span>
                            <span class="fw-semibold">{{ $event->created_at->format('d/m/Y H:i') }}</span>
                        </li>
                        <li class="d-flex justify-content-between">
                            <span class="text-muted">Actualizado</span>
                            <span class="fw-semibold">{{ $event->updated_at->format('d/m/Y H:i') }}</span>
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
                        <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-dark rounded-pill">
                            <i class="bi bi-pencil me-1"></i> Editar evento
                        </a>
                        {{-- Botón "Ver en el sitio" comentado hasta crear la ruta pública --}}
                        {{--
                        <a href="{{ route('events.show', $event->slug) }}" target="_blank"
                           class="btn btn-outline-secondary rounded-pill">
                            <i class="bi bi-box-arrow-up-right me-1"></i> Ver en el sitio
                        </a>
                        --}}
                        <form method="POST" action="{{ route('admin.events.destroy', $event) }}"
                              onsubmit="return confirm('¿Eliminar este evento? Esta acción no se puede deshacer.');">
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