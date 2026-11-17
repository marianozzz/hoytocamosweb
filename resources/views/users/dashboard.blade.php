@extends('layouts.app')

@section('title', 'Mi panel — HoyTocamos')

@section('content')
    <div class="container py-4">

        {{-- Hero de bienvenida --}}
        <section class="ht-cta rounded-4 p-4 p-lg-5 mb-5">
            <div class="position-relative" style="z-index: 1;">
                <span class="ht-badge-live mb-3">
                    <span class="dot"></span> Tu panel
                </span>
                <h1 class="display-6 fw-bold mb-3" style="color: #fff;">
                    Hola, {{ auth()->user()->name }}.<br>
                    <span style="color: var(--ht-yellow);">Bienvenido</span> a HoyTocamos.
                </h1>
                <p class="mb-4" style="max-width: 560px; color: rgba(255,255,255,.75);">
                    Desde aquí podrás publicar tus fechas, guardar eventos favoritos
                    y gestionar tu perfil de banda u organizador.
                </p>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('profile.index') }}" class="btn btn-ht-primary">
                        <i class="bi bi-person-circle me-1"></i> Ver mi perfil
                    </a>
                    <a href="#" class="btn btn-ht-ghost disabled">
                        <i class="bi bi-plus-lg me-1"></i> Publicar evento (Pronto)
                    </a>
                </div>
            </div>
        </section>

        {{-- Tres tarjetas superiores --}}
        <div class="row row-cols-1 row-cols-md-3 g-4 mb-5">
            <div class="col">
                <div class="ht-card h-100">
                    <div class="card-body p-4 text-center">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3"
                             style="width: 64px; height: 64px; background: rgba(230,0,126,.1);">
                            <i class="bi bi-calendar-event fs-3" style="color: var(--ht-magenta);"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Mis eventos</h5>
                        <p class="text-muted small mb-0">Publica y gestiona tus fechas</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="ht-card h-100">
                    <div class="card-body p-4 text-center">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3"
                             style="width: 64px; height: 64px; background: rgba(0,224,208,.12);">
                            <i class="bi bi-heart fs-3" style="color: var(--ht-cyan);"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Favoritos</h5>
                        <p class="text-muted small mb-0">Eventos que guardaste</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <a href="{{ route('profile.index') }}" class="text-decoration-none">
                    <div class="ht-card h-100">
                        <div class="card-body p-4 text-center">
                            <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3"
                                 style="width: 64px; height: 64px; background: rgba(255,230,0,.18);">
                                <i class="bi bi-person-badge fs-3" style="color: #b8a400;"></i>
                            </div>
                            <h5 class="fw-bold mb-2 text-dark">Mi perfil</h5>
                            <p class="text-muted small mb-0">Tu banda u organizador</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        {{-- Tarjeta grande: próximos eventos --}}
        <div class="ht-card mb-5">
            <div class="card-body p-4 p-lg-5">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
                    <div>
                        <span class="ht-date-badge mb-3">Próximamente</span>
                        <h3 class="fw-bold mt-3 mb-1">Tus próximas fechas</h3>
                        <p class="ht-venue mb-0">📍 Aún no has publicado eventos</p>
                    </div>
                    <span class="badge rounded-pill"
                          style="background: var(--ht-dark); color: var(--ht-yellow);">
                        Maqueta
                    </span>
                </div>

                <div class="d-flex align-items-center gap-3 flex-wrap">
                    <button class="btn btn-ht-primary btn-lg" disabled>
                        <i class="bi bi-plus-lg"></i> Publicar evento
                    </button>
                    <p class="text-muted small mb-0">Pronto podrás publicar tus propias fechas.</p>
                </div>
            </div>
        </div>

        {{-- Novedades --}}
        <section class="mb-4">
            <h2 class="ht-section-title h4 mb-0">Novedades de la escena</h2>
            <p class="text-muted mb-4 mt-3">Esto es lo que está pasando en HoyTocamos.</p>

            <div class="row g-3">
                <div class="col-md-6">
                    <div class="ht-news h-100">
                        <h6 class="fw-bold mb-1">Nuevo espacio para tocadas en el centro</h6>
                        <p class="text-muted small mb-2">Publicado hace 2 días</p>
                        <p class="mb-0">El antiguo mercado municipal abre sus puertas a eventos culturales independientes.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="ht-news h-100">
                        <h6 class="fw-bold mb-1">Convocatoria abierta para bandas emergentes</h6>
                        <p class="text-muted small mb-2">Publicado hace 5 días</p>
                        <p class="mb-0">Buscan proyectos para grabar un split de vinilo. Recepción de maquetas hasta fin de mes.</p>
                    </div>
                </div>
            </div>
        </section>

    </div>
@endsection