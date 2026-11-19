@extends('layouts.admin')

@section('title', 'Nuevo evento — Admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h1 class="h3 fw-bold mb-1">Nuevo evento</h1>
            <p class="text-muted mb-0">Publica una nueva fecha en el calendario.</p>
        </div>
        <a href="{{ route('admin.events.index') }}" class="btn btn-outline-secondary rounded-pill">
            <i class="bi bi-arrow-left me-1"></i> Volver al listado
        </a>
    </div>

    {{-- Errores generales --}}
    @if ($errors->any())
        <div class="alert alert-danger rounded-3" role="alert">
            <i class="bi bi-exclamation-triangle me-1"></i>
            Revisa los campos marcados en rojo.
        </div>
    @endif

    <form method="POST" action="{{ route('admin.events.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="row g-4">
            {{-- Columna principal --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">

                        {{-- Título --}}
                        <div class="mb-3">
                            <label for="title" class="form-label fw-semibold">Título del evento</label>
                            <input type="text" id="title" name="title"
                                   class="form-control @error('title') is-invalid @enderror"
                                   value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Descripción --}}
                        <div class="mb-0">
                            <label for="description" class="form-label fw-semibold">Descripción</label>
                            <textarea id="description" name="description" rows="8"
                                      class="form-control @error('description') is-invalid @enderror"
                                      placeholder="Detalles del evento, bandas invitadas, horarios, etc.">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

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

                        {{-- Tipo de evento --}}
                        <div class="mb-3">
                            <label for="event_type_id" class="form-label fw-semibold">Tipo de evento</label>
                            <select id="event_type_id" name="event_type_id"
                                    class="form-select @error('event_type_id') is-invalid @enderror">
                                <option value="">Sin definir</option>
                                @foreach ($eventTypes as $type)
                                    <option value="{{ $type->id }}"
                                        {{ old('event_type_id') == $type->id ? 'selected' : '' }}>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('event_type_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Componente Livewire: venue + dirección + ciudad --}}
                        @livewire('venue-selector', [
                            'venueId' => old('venue_id'),
                            'address' => old('address'),
                            'cityId' => old('city_id'),
                        ])

                        {{-- Fecha de inicio --}}
                        <div class="mb-3 mt-3">
                            <label for="starts_at" class="form-label fw-semibold">Fecha y hora de inicio</label>
                            <input type="datetime-local" id="starts_at" name="starts_at"
                                   class="form-control @error('starts_at') is-invalid @enderror"
                                   value="{{ old('starts_at') }}" required>
                            @error('starts_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Fecha de fin --}}
                        <div class="mb-0">
                            <label for="ends_at" class="form-label fw-semibold">Fecha y hora de fin</label>
                            <input type="datetime-local" id="ends_at" name="ends_at"
                                   class="form-control @error('ends_at') is-invalid @enderror"
                                   value="{{ old('ends_at') }}">
                            @error('ends_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Opcional.</div>
                        </div>
                    </div>
                </div>

                {{-- Publicación --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3">
                            <i class="bi bi-gear me-1" style="color: var(--ht-cyan);"></i>
                            Publicación
                        </h6>

                        <div class="mb-0">
                            <label for="published" class="form-label fw-semibold">Estado</label>
                            <select id="published" name="published"
                                    class="form-select @error('published') is-invalid @enderror">
                                <option value="0" {{ old('published') == '0' ? 'selected' : '' }}>Borrador</option>
                                <option value="1" {{ old('published') == '1' ? 'selected' : '' }}>Publicado</option>
                            </select>
                            @error('published')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Portada --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3">
                            <i class="bi bi-image me-1" style="color: #b8a400;"></i>
                            Imagen de portada
                        </h6>
                        <input type="file" id="cover" name="cover" accept="image/*"
                               class="form-control @error('cover') is-invalid @enderror">
                        @error('cover')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Opcional. Máx. 2MB.</div>
                    </div>
                </div>

                {{-- Botones --}}
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-dark rounded-pill">
                        <i class="bi bi-check-lg me-1"></i> Guardar evento
                    </button>
                    <a href="{{ route('admin.events.index') }}" class="btn btn-outline-secondary rounded-pill">
                        Cancelar
                    </a>
                </div>
            </div>
        </div>
    </form>
@endsection