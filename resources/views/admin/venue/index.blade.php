@extends('layouts.admin')

@section('title', 'Lugares — Admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h1 class="h3 fw-bold mb-1">Lugares</h1>
            <p class="text-muted mb-0">Gestiona bares, centros culturales y espacios de la escena.</p>
        </div>
        <a href="{{ route('admin.venues.create') }}" class="btn btn-dark rounded-pill">
            <i class="bi bi-plus-lg me-1"></i> Nuevo lugar
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
            @if ($venues->isEmpty())
                <div class="text-center py-5">
                    <i class="bi bi-geo-alt fs-1 text-muted"></i>
                    <p class="text-muted mt-3 mb-0">Aún no hay lugares cargados.</p>
                    <p class="text-muted small">Crea el primero con el botón "Nuevo lugar".</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Lugar</th>
                                <th>Dirección</th>
                                <th>Ciudad</th>
                                <th>Galería</th>
                                <th class="text-end pe-4">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($venues as $venue)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center gap-3">
                                            @if ($venue->coverUrl())
                                                <img src="{{ $venue->coverUrl() }}" alt="Portada"
                                                     class="rounded-3"
                                                     style="width: 48px; height: 48px; object-fit: cover;">
                                            @else
                                                <div class="rounded-3 bg-light d-flex align-items-center justify-content-center"
                                                     style="width: 48px; height: 48px;">
                                                    <i class="bi bi-building text-muted"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="fw-semibold">{{ $venue->name }}</div>
                                                <div class="text-muted small">{{ $venue->slug }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-muted">{{ $venue->address ?? 'Sin definir' }}</td>
                                    <td>{{ $venue->city?->name ?? 'Sin definir' }}</td>
                                    <td>
                                        @if ($venue->gallery && count($venue->gallery) > 0)
                                            <span class="badge rounded-pill bg-light text-dark border">
                                                <i class="bi bi-images me-1"></i> {{ count($venue->gallery) }}
                                            </span>
                                        @else
                                            <span class="text-muted small">Sin imágenes</span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        <a href="{{ route('admin.venues.show', $venue) }}"
                                           class="btn btn-sm btn-outline-secondary rounded-pill" title="Ver">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.venues.edit', $venue) }}"
                                           class="btn btn-sm btn-outline-primary rounded-pill" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.venues.destroy', $venue) }}"
                                              class="d-inline" onsubmit="return confirm('¿Eliminar este lugar?');">
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
                    {{ $venues->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection