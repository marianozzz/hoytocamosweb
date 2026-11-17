@extends('layouts.app')

@section('title', 'Mi perfil — HoyTocamos')

@section('content')
    <div class="container py-4">

        {{-- Cabecera del perfil --}}
        <section class="ht-cta rounded-4 p-4 p-lg-5 mb-5 position-relative">
            <div class="row align-items-center position-relative" style="z-index: 1;">
                <div class="col-md-3 text-center text-md-start mb-3 mb-md-0">
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center overflow-hidden"
                         style="width: 100px; height: 100px; background: var(--ht-magenta); color: #fff; font-size: 2.5rem; font-weight: 700; border: 4px solid rgba(255,255,255,.2);">
                        @if ($user->avatarUrl())
                            <img src="{{ $user->avatarUrl() }}" alt="Avatar de {{ $user->name }}"
                                 style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        @endif
                    </div>
                </div>
                <div class="col-md-9 text-center text-md-start">
                    <span class="ht-badge-live mb-2">
                        <span class="dot"></span> Miembro
                    </span>
                    <h1 class="display-6 fw-bold mb-1" style="color: #fff;">
                        {{ $user->name }}
                    </h1>
                    <p class="mb-2" style="color: rgba(255,255,255,.7);">
                        {{ $user->email }}
                    </p>

                    {{-- Badges de estatus --}}
                    <div class="d-flex flex-wrap gap-3 justify-content-center justify-content-md-start mt-3">
                        <span class="badge rounded-pill px-3 py-2" style="background: var(--ht-dark); color: var(--ht-yellow);">
                            <i class="bi bi-star-fill me-1"></i> Full User
                        </span>
                        <span class="badge rounded-pill px-3 py-2" style="background: rgba(255,255,255,.1); color: #fff;">
                            <i class="bi bi-heart-fill me-1" style="color: var(--ht-magenta);"></i> 0 Karma
                        </span>
                        <span class="badge rounded-pill px-3 py-2" style="background: rgba(255,255,255,.1); color: #fff;">
                            <i class="bi bi-people-fill me-1" style="color: var(--ht-cyan);"></i> 0 Seguidores
                        </span>
                    </div>

                    {{-- Tags musicales en la cabecera --}}
                    <div class="d-flex flex-wrap gap-2 justify-content-center justify-content-md-start mt-3">
                        @forelse ($user->genres as $genre)
                            <span class="badge rounded-pill px-3 py-2" style="background: rgba(230,0,126,.2); color: #fff; border: 1px solid rgba(230,0,126,.5);">
                                <i class="bi bi-music-note me-1"></i> {{ $genre->name }}
                            </span>
                        @empty
                            <span class="small" style="color: rgba(255,255,255,.5);">Aún no has elegido géneros musicales.</span>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>

        <div class="row g-4">
            {{-- Columna izquierda --}}
            <div class="col-lg-4">

                {{-- Tarjeta Información rediseñada --}}
                <div class="ht-card ht-card-static h-100">
                    <div class="card-body p-0">

                        {{-- Cabecera de la tarjeta --}}
                        <div class="p-4 pb-3 border-bottom d-flex align-items-center justify-content-between">
                            <h5 class="fw-bold mb-0">
                                <i class="bi bi-person-vcard me-2" style="color: var(--ht-magenta);"></i>
                                Información
                            </h5>
                            <span class="badge rounded-pill"
                                  style="background: rgba(230,0,126,.1); color: var(--ht-magenta); font-weight: 600;">
                                <i class="bi bi-patch-check-fill me-1"></i> Verificado
                            </span>
                        </div>

                        {{-- Cuerpo de la tarjeta --}}
                        <div class="p-4">

                            {{-- Bio corta --}}
                            <p class="text-muted small fst-italic mb-4">
                                "Viviendo la escena under, un evento a la vez."
                            </p>

                            {{-- Datos con iconos en círculos --}}
                            <div class="d-flex flex-column gap-3">

                                {{-- Email --}}
                                <div class="d-flex align-items-center gap-3">
                                    <div class="d-flex align-items-center justify-content-center rounded-circle flex-shrink-0"
                                         style="width: 40px; height: 40px; background: rgba(230,0,126,.1);">
                                        <i class="bi bi-envelope-fill" style="color: var(--ht-magenta);"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <div class="text-muted small">Correo</div>
                                        <div class="fw-semibold text-truncate">{{ $user->email }}</div>
                                    </div>
                                </div>

                                {{-- Miembro desde --}}
                                <div class="d-flex align-items-center gap-3">
                                    <div class="d-flex align-items-center justify-content-center rounded-circle flex-shrink-0"
                                         style="width: 40px; height: 40px; background: rgba(0,224,208,.12);">
                                        <i class="bi bi-calendar-check-fill" style="color: var(--ht-cyan);"></i>
                                    </div>
                                    <div>
                                        <div class="text-muted small">Miembro desde</div>
                                        <div class="fw-semibold">{{ $user->created_at->format('M Y') }}</div>
                                    </div>
                                </div>

                                {{-- Ubicación --}}
                                <div class="d-flex align-items-center gap-3">
                                    <div class="d-flex align-items-center justify-content-center rounded-circle flex-shrink-0"
                                         style="width: 40px; height: 40px; background: rgba(255,230,0,.18);">
                                        <i class="bi bi-geo-alt-fill" style="color: #b8a400;"></i>
                                    </div>
                                    <div>
                                        <div class="text-muted small">Ubicación</div>
                                        @if ($user->city || $user->province || $user->country)
                                            <div class="fw-semibold">
                                                @if ($user->city)
                                                    {{ $user->city->name }}
                                                @endif
                                                @if ($user->province)
                                                    {{ $user->city ? ', ' : '' }}{{ $user->province->name }}
                                                @endif
                                                @if ($user->country)
                                                    {{ ($user->city || $user->province) ? ', ' : '' }}{{ $user->country->name }}
                                                @endif
                                            </div>
                                        @else
                                            <div class="fw-semibold text-muted fst-italic">Aún no definida</div>
                                        @endif
                                    </div>
                                </div>

                            </div>

                            {{-- Botón editar --}}
                            <a href="{{ route('profile.edit') }}" class="btn btn-ht-primary w-100 mt-4">
                                <i class="bi bi-pencil-square me-1"></i> Editar perfil
                            </a>

                        </div>
                    </div>
                </div>

            </div>

            {{-- Columna derecha --}}
            <div class="col-lg-8">
                {{-- Estadísticas --}}
                <div class="row row-cols-1 row-cols-sm-3 g-3 mb-4">
                    <div class="col">
                        <div class="ht-card ht-card-static text-center p-3">
                            <i class="bi bi-file-post fs-3" style="color: var(--ht-magenta);"></i>
                            <h4 class="fw-bold mb-0 mt-2">0</h4>
                            <small class="text-muted">Posts</small>
                        </div>
                    </div>
                    <div class="col">
                        <div class="ht-card ht-card-static text-center p-3">
                            <i class="bi bi-chat-dots fs-3" style="color: var(--ht-cyan);"></i>
                            <h4 class="fw-bold mb-0 mt-2">0</h4>
                            <small class="text-muted">Comentarios</small>
                        </div>
                    </div>
                    <div class="col">
                        <div class="ht-card ht-card-static text-center p-3">
                            <i class="bi bi-award fs-3" style="color: #b8a400;"></i>
                            <h4 class="fw-bold mb-0 mt-2">0</h4>
                            <small class="text-muted">Medallas</small>
                        </div>
                    </div>
                </div>

                {{-- Gustos musicales (solo los elegidos) --}}
                <div class="ht-card ht-card-static mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                            <h5 class="fw-bold mb-0">
                                <i class="bi bi-music-note-beamed me-2" style="color: var(--ht-cyan);"></i>
                                Gustos musicales
                            </h5>
                            <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-outline-secondary rounded-pill">
                                <i class="bi bi-pencil me-1"></i> Editar tags
                            </a>
                        </div>

                        <p class="text-muted small mb-3">
                            Estos son los géneros que te gustan. Aparecerán en tu perfil público
                            y ayudarán a recomendarte eventos.
                        </p>

                        {{-- Solo los géneros elegidos --}}
                        <div class="d-flex flex-wrap gap-2">
                            @forelse ($user->genres as $genre)
                                <span class="badge rounded-pill px-3 py-2" style="background: rgba(230,0,126,.1); color: var(--ht-magenta); font-weight: 600; border: 1px solid rgba(230,0,126,.3);">
                                    <i class="bi bi-music-note me-1"></i> {{ $genre->name }}
                                </span>
                            @empty
                                <span class="text-muted small">Aún no has seleccionado géneros musicales. Puedes añadirlos desde "Editar tags".</span>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- Actividad reciente --}}
                <div class="ht-card ht-card-static">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3">
                            <i class="bi bi-activity me-2" style="color: var(--ht-magenta);"></i>
                            Actividad reciente
                        </h5>
                        <div class="text-center py-4">
                            <i class="bi bi-inbox fs-1 text-muted"></i>
                            <p class="text-muted mt-2 mb-0">Aún no tienes actividad en HoyTocamos.</p>
                            <p class="text-muted small">Cuando publiques o comentes eventos, aparecerá aquí.</p>
                        </div>
                    </div>
                </div>

                {{-- Opciones de cuenta --}}
                <div class="ht-card ht-card-static mt-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3">
                            <i class="bi bi-gear me-2" style="color: var(--ht-magenta);"></i>
                            Opciones de cuenta
                        </h5>
                        <div class="list-group list-group-flush">
                            <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center disabled">
                                <span><i class="bi bi-key me-2"></i> Cambiar contraseña</span>
                                <span class="badge bg-secondary rounded-pill">Pronto</span>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center disabled">
                                <span><i class="bi bi-bell me-2"></i> Notificaciones</span>
                                <span class="badge bg-secondary rounded-pill">Pronto</span>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center disabled">
                                <span><i class="bi bi-shield-lock me-2"></i> Privacidad</span>
                                <span class="badge bg-secondary rounded-pill">Pronto</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection