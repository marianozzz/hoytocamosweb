@extends('layouts.admin')

@section('title', 'Calendario — Admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h1 class="h3 fw-bold mb-1">Calendario</h1>
            <p class="text-muted mb-0">Gestiona los eventos y fechas de la escena.</p>
        </div>
        <a href="{{ route('admin.events.create') }}" class="btn btn-dark rounded-pill">
            <i class="bi bi-plus-lg me-1"></i> Nuevo evento
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
            @if ($events->isEmpty())
                <div class="text-center py-5">
                    <i class="bi bi-calendar-x fs-1 text-muted"></i>
                    <p class="text-muted mt-3 mb-0">Aún no hay eventos creados.</p>
                    <p class="text-muted small">Crea el primero con el botón "Nuevo evento".</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Evento</th>
                                <th>Fecha</th>
                                <th>Lugar</th>
                                <th>Ciudad</th>
                                <th>Estado</th>
                                <th class="text-end pe-4">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($events as $event)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center gap-3">
                                            @if ($event->coverUrl())
                                                <img src="{{ $event->coverUrl() }}" alt="Portada"
                                                     class="rounded-3"
                                                     style="width: 48px; height: 48px; object-fit: cover;">
                                            @else
                                                <div class="rounded-3 bg-light d-flex align-items-center justify-content-center"
                                                     style="width: 48px; height: 48px;">
                                                    <i class="bi bi-calendar-event text-muted"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="fw-semibold">{{ $event->title }}</div>
                                                <div class="text-muted small">{{ $event->slug }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-semibold">{{ $event->starts_at->format('d/m/Y') }}</div>
                                        <div class="text-muted small">{{ $event->starts_at->format('H:i') }} hs</div>
                                    </td>
                                    <td>{{ $event->venue?->name ?? 'Sin definir' }}</td>
                                    <td class="text-muted">
                                        {{ $event->city?->name ?? 'Sin definir' }}
                                    </td>
                                    <td>
                                        @if ($event->published)
                                            <span class="badge rounded-pill bg-success">Publicado</span>
                                        @else
                                            <span class="badge rounded-pill bg-secondary">Borrador</span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        <a href="{{ route('admin.events.show', $event) }}"
                                           class="btn btn-sm btn-outline-secondary rounded-pill" title="Ver">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.events.edit', $event) }}"
                                           class="btn btn-sm btn-outline-primary rounded-pill" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.events.destroy', $event) }}"
                                              class="d-inline" onsubmit="return confirm('¿Eliminar este evento?');">
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
                    {{ $events->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection