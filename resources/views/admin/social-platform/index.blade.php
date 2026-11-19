@extends('layouts.admin')

@section('title', 'Plataformas sociales — Admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h1 class="h3 fw-bold mb-1">Plataformas sociales</h1>
            <p class="text-muted mb-0">Gestiona las redes sociales disponibles en el sitio.</p>
        </div>
        <a href="{{ route('admin.social-platforms.create') }}" class="btn btn-dark rounded-pill">
            <i class="bi bi-plus-lg me-1"></i> Nueva plataforma
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
            @if ($platforms->isEmpty())
                <div class="text-center py-5">
                    <i class="bi bi-share fs-1 text-muted"></i>
                    <p class="text-muted mt-3 mb-0">Aún no hay plataformas cargadas.</p>
                    <p class="text-muted small">Crea la primera con el botón "Nueva plataforma".</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Plataforma</th>
                                <th>Slug</th>
                                <th>URL base</th>
                                <th>Estado</th>
                                <th class="text-end pe-4">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($platforms as $platform)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center"
                                                 style="width: 40px; height: 40px;">
                                                <i class="bi {{ $platform->icon ?? 'bi-share' }} fs-5"></i>
                                            </div>
                                            <div class="fw-semibold">{{ $platform->name }}</div>
                                        </div>
                                    </td>
                                    <td><code>{{ $platform->slug }}</code></td>
                                    <td class="text-muted small">{{ $platform->base_url ?? '—' }}</td>
                                    <td>
                                        @if ($platform->active)
                                            <span class="badge rounded-pill bg-success">Activa</span>
                                        @else
                                            <span class="badge rounded-pill bg-secondary">Inactiva</span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        <a href="{{ route('admin.social-platforms.edit', $platform) }}"
                                           class="btn btn-sm btn-outline-primary rounded-pill" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.social-platforms.destroy', $platform) }}"
                                              class="d-inline" onsubmit="return confirm('¿Eliminar esta plataforma? Se borrarán también los enlaces asociados.');">
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
                    {{ $platforms->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection