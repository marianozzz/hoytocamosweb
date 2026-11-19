@extends('layouts.admin')

@section('title', 'Ver banda — Admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h1 class="h3 fw-bold mb-1">Detalle de la banda</h1>
            <p class="text-muted mb-0">Vista previa de cómo se verá el proyecto en el sitio.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.bands.index') }}" class="btn btn-outline-secondary rounded-pill">
                <i class="bi bi-arrow-left me-1"></i> Volver
            </a>
            <a href="{{ route('admin.bands.edit', $band) }}" class="btn btn-dark rounded-pill">
                <i class="bi bi-pencil me-1"></i> Editar
            </a>
        </div>
    </div>

    <div class="row g-4">
        {{-- Columna principal --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 p-lg-5">

                    {{-- Estado y tipo --}}
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        @if ($band->status === 'approved')
                            <span class="badge rounded-pill bg-success">Aprobada</span>
                        @elseif ($band->status === 'rejected')
                            <span class="badge rounded-pill bg-danger">Rechazada</span>
                        @else
                            <span class="badge rounded-pill bg-warning text-dark">Pendiente</span>
                        @endif

                        @if ($band->entityType)
                            <span class="badge rounded-pill bg-light text-dark border">
                                <i class="bi bi-tag me-1"></i> {{ $band->entityType->name }}
                            </span>
                        @endif

                        @if ($band->founded_at)
                            <span class="badge rounded-pill bg-light text-dark border">
                                <i class="bi bi-calendar3 me-1"></i>
                                Desde {{ $band->founded_at->format('Y') }}
                            </span>
                        @endif
                    </div>

                    {{-- Portada --}}
                    @if ($band->coverUrl())
                        <div class="mb-4">
                            <img src="{{ $band->coverUrl() }}"
                                 alt="{{ $band->name }}"
                                 class="img-fluid rounded-4 shadow-sm w-100"
                                 style="max-height: 400px; object-fit: cover;">
                        </div>
                    @endif

                    {{-- Título --}}
                    <h1 class="h2 fw-bold mb-2">{{ $band->name }}</h1>

                    {{-- Slug y autor --}}
                    <p class="text-muted small mb-4">
                        <code>{{ $band->slug }}</code> ·
                        Creada por <strong>{{ $band->user->name }}</strong>
                    </p>

                    {{-- Bio --}}
                    @if ($band->bio)
                        <article class="post-body">
                            {!! nl2br(e($band->bio)) !!}
                        </article>
                    @endif

                    {{-- Géneros --}}
                    @if ($band->genres->count() > 0)
                        <hr class="my-4">
                        <h6 class="fw-bold mb-3">
                            <i class="bi bi-music-note-beamed me-1" style="color: var(--ht-cyan);"></i>
                            Géneros / disciplinas
                        </h6>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach ($band->genres as $genre)
                                <span class="badge rounded-pill px-3 py-2"
                                      style="background: rgba(230,0,126,.1); color: var(--ht-magenta); font-weight: 600; border: 1px solid rgba(230,0,126,.3);">
                                    {{ $genre->name }}
                                </span>
                            @endforeach
                        </div>
                    @endif

                </div>
            </div>

            {{-- Galería --}}
            @if ($band->galleryUrls())
                <div class="card border-0 shadow-sm mt-4">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3">
                            <i class="bi bi-images me-1" style="color: var(--ht-cyan);"></i>
                            Galería
                        </h6>
                        <div class="row g-3">
                            @foreach ($band->galleryUrls() as $url)
                                <div class="col-md-4">
                                    <img src="{{ $url }}" alt="Imagen de {{ $band->name }}"
                                         class="img-fluid rounded-3 w-100"
                                         style="height: 160px; object-fit: cover;">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            {{-- Integrantes --}}
            @if ($band->members->count() > 0)
                <div class="card border-0 shadow-sm mt-4">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3">
                            <i class="bi bi-people me-1" style="color: var(--ht-magenta);"></i>
                            Integrantes
                        </h6>
                        <ul class="list-unstyled mb-0">
                            @foreach ($band->members as $member)
                                <li class="d-flex align-items-center gap-2 mb-2">
                                    <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center"
                                         style="width: 32px; height: 32px; font-size: .75rem;">
                                        {{ strtoupper(substr($member->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-semibold small">{{ $member->name }}</div>
                                        <div class="text-muted small">{{ $member->pivot->role }}</div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
        </div>

        {{-- Columna lateral --}}
        <div class="col-lg-4">
            {{-- Origen --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">
                        <i class="bi bi-geo-alt me-1" style="color: var(--ht-magenta);"></i>
                        Origen
                    </h6>
                    <ul class="list-unstyled small mb-0">
                        <li class="mb-2">
                            <span class="text-muted d-block">Ciudad</span>
                            <span class="fw-semibold">{{ $band->city?->name ?? 'Sin definir' }}</span>
                        </li>
                        <li class="mb-2">
                            <span class="text-muted d-block">Provincia</span>
                            <span class="fw-semibold">{{ $band->province?->name ?? 'Sin definir' }}</span>
                        </li>
                        <li>
                            <span class="text-muted d-block">País</span>
                            <span class="fw-semibold">{{ $band->country?->name ?? 'Sin definir' }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Redes sociales --}}
            @if ($band->socialLinks->count() > 0)
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3">
                            <i class="bi bi-share me-1" style="color: var(--ht-magenta);"></i>
                            Redes sociales
                        </h6>
                        <div class="d-flex flex-column gap-2">
                            @foreach ($band->socialLinks as $link)
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
                            <span class="fw-semibold">#{{ $band->id }}</span>
                        </li>
                        @if ($band->founded_at)
                            <li class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Fundada</span>
                                <span class="fw-semibold">{{ $band->founded_at->format('d/m/Y') }}</span>
                            </li>
                        @endif
                        <li class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Creada</span>
                            <span class="fw-semibold">{{ $band->created_at->format('d/m/Y H:i') }}</span>
                        </li>
                        @if ($band->approved_at)
                            <li class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Aprobada</span>
                                <span class="fw-semibold">{{ $band->approved_at->format('d/m/Y H:i') }}</span>
                            </li>
                        @endif
                        @if ($band->approvedBy)
                            <li class="d-flex justify-content-between">
                                <span class="text-muted">Aprobada por</span>
                                <span class="fw-semibold">{{ $band->approvedBy->name }}</span>
                            </li>
                        @endif
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
                        <a href="{{ route('admin.bands.edit', $band) }}" class="btn btn-dark rounded-pill">
                            <i class="bi bi-pencil me-1"></i> Editar banda
                        </a>
                        <form method="POST" action="{{ route('admin.bands.destroy', $band) }}"
                              onsubmit="return confirm('¿Eliminar esta banda? Esta acción no se puede deshacer.');">
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