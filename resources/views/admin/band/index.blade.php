@extends('layouts.admin')

@section('title', 'Bandas — Admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h1 class="h3 fw-bold mb-1">Bandas</h1>
            <p class="text-muted mb-0">Gestiona las bandas y artistas de la escena.</p>
        </div>
        <a href="{{ route('admin.bands.create') }}" class="btn btn-dark rounded-pill">
            <i class="bi bi-plus-lg me-1"></i> Nueva banda
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
            @if ($bands->isEmpty())
                <div class="text-center py-5">
                    <i class="bi bi-music-note-list fs-1 text-muted"></i>
                    <p class="text-muted mt-3 mb-0">Aún no hay bandas cargadas.</p>
                    <p class="text-muted small">Crea la primera con el botón "Nueva banda".</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Banda</th>
                                <th>Creada por</th>
                                <th>Estado</th>
                                <th>Aprobada por</th>
                                <th class="text-end pe-4">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bands as $band)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center gap-3">
                                            @if ($band->coverUrl())
                                                <img src="{{ $band->coverUrl() }}" alt="Portada"
                                                     class="rounded-3"
                                                     style="width: 48px; height: 48px; object-fit: cover;">
                                            @else
                                                <div class="rounded-3 bg-light d-flex align-items-center justify-content-center"
                                                     style="width: 48px; height: 48px;">
                                                    <i class="bi bi-music-note text-muted"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="fw-semibold">{{ $band->name }}</div>
                                                <div class="text-muted small">{{ $band->slug }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-muted small">{{ $band->user->name }}</td>
                                    <td>
                                        @if ($band->status === 'approved')
                                            <span class="badge rounded-pill bg-success">Aprobada</span>
                                        @elseif ($band->status === 'rejected')
                                            <span class="badge rounded-pill bg-danger">Rechazada</span>
                                        @else
                                            <span class="badge rounded-pill bg-warning text-dark">Pendiente</span>
                                        @endif
                                    </td>
                                    <td class="text-muted small">
                                        {{ $band->approvedBy?->name ?? '—' }}
                                    </td>
                                    <td class="text-end pe-4">
                                        <a href="{{ route('admin.bands.show', $band) }}"
                                           class="btn btn-sm btn-outline-secondary rounded-pill" title="Ver">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.bands.edit', $band) }}"
                                           class="btn btn-sm btn-outline-primary rounded-pill" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.bands.destroy', $band) }}"
                                              class="d-inline" onsubmit="return confirm('¿Eliminar esta banda?');">
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
                    {{ $bands->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection