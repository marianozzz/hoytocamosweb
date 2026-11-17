@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h1 class="h3 fw-bold mb-1">Dashboard</h1>
            <p class="text-muted mb-0">Resumen general de HoyTocamos.</p>
        </div>
        <span class="badge rounded-pill bg-dark">
            <i class="bi bi-calendar3 me-1"></i> {{ now()->format('d/m/Y') }}
        </span>
    </div>

    {{-- Tarjetas de resumen --}}
    <div class="row g-4 mb-4">
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted small mb-1">Usuarios registrados</p>
                            <h2 class="fw-bold mb-0">0</h2>
                        </div>
                        <div class="rounded-circle d-flex align-items-center justify-content-center"
                             style="width: 48px; height: 48px; background: rgba(230,0,126,.1);">
                            <i class="bi bi-people fs-4" style="color: var(--ht-magenta);"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted small mb-1">Géneros musicales</p>
                            <h2 class="fw-bold mb-0">0</h2>
                        </div>
                        <div class="rounded-circle d-flex align-items-center justify-content-center"
                             style="width: 48px; height: 48px; background: rgba(0,224,208,.12);">
                            <i class="bi bi-music-note-beamed fs-4" style="color: var(--ht-cyan);"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted small mb-1">Ciudades cargadas</p>
                            <h2 class="fw-bold mb-0">0</h2>
                        </div>
                        <div class="rounded-circle d-flex align-items-center justify-content-center"
                             style="width: 48px; height: 48px; background: rgba(255,230,0,.18);">
                            <i class="bi bi-geo-alt fs-4" style="color: #b8a400;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted small mb-1">Posts del blog</p>
                            <h2 class="fw-bold mb-0">0</h2>
                        </div>
                        <div class="rounded-circle d-flex align-items-center justify-content-center"
                             style="width: 48px; height: 48px; background: rgba(13,13,18,.08);">
                            <i class="bi bi-journal-text fs-4 text-dark"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Accesos rápidos --}}
    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">
                        <i class="bi bi-lightning-charge me-2" style="color: var(--ht-magenta);"></i>
                        Accesos rápidos
                    </h5>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <a href="#" class="text-decoration-none">
                                <div class="border rounded-3 p-3 text-center h-100">
                                    <i class="bi bi-person-plus fs-3 text-primary"></i>
                                    <div class="small fw-semibold mt-2 text-dark">Nuevo usuario</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="#" class="text-decoration-none">
                                <div class="border rounded-3 p-3 text-center h-100">
                                    <i class="bi bi-journal-plus fs-3 text-success"></i>
                                    <div class="small fw-semibold mt-2 text-dark">Nuevo post</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="#" class="text-decoration-none">
                                <div class="border rounded-3 p-3 text-center h-100">
                                    <i class="bi bi-calendar-plus fs-3 text-warning"></i>
                                    <div class="small fw-semibold mt-2 text-dark">Nuevo evento</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">
                        <i class="bi bi-info-circle me-2" style="color: var(--ht-cyan);"></i>
                        Estado del sistema
                    </h5>
                    <ul class="list-unstyled small mb-0">
                        <li class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Laravel</span>
                            <span class="fw-semibold">{{ app()->version() }}</span>
                        </li>
                        <li class="d-flex justify-content-between mb-2">
                            <span class="text-muted">PHP</span>
                            <span class="fw-semibold">{{ phpversion() }}</span>
                        </li>
                        <li class="d-flex justify-content-between">
                            <span class="text-muted">Entorno</span>
                            <span class="fw-semibold">{{ app()->environment() }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Actividad reciente (placeholder) --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <h5 class="fw-bold mb-3">
                <i class="bi bi-activity me-2" style="color: var(--ht-magenta);"></i>
                Actividad reciente
            </h5>
            <div class="text-center py-4">
                <i class="bi bi-inbox fs-1 text-muted"></i>
                <p class="text-muted mt-2 mb-0">Aún no hay actividad registrada.</p>
                <p class="text-muted small">Cuando haya usuarios, posts o eventos, aparecerá aquí.</p>
            </div>
        </div>
    </div>
@endsection