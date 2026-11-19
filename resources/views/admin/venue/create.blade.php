@extends('layouts.admin')

@section('title', 'Nuevo lugar — Admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h1 class="h3 fw-bold mb-1">Nuevo lugar</h1>
            <p class="text-muted mb-0">Carga un bar, centro cultural o espacio de la escena.</p>
        </div>
        <a href="{{ route('admin.venues.index') }}" class="btn btn-outline-secondary rounded-pill">
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

    <form method="POST" action="{{ route('admin.venues.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="row g-4">
            {{-- Columna principal --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">

                        {{-- Nombre --}}
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">Nombre del lugar</label>
                            <input type="text" id="name" name="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name') }}"
                                   placeholder="Bar Botellas, Centro Cultural Nova, etc." required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Descripción --}}
                        <div class="mb-3">
                            <label for="description" class="form-label fw-semibold">Descripción</label>
                            <textarea id="description" name="description" rows="5"
                                      class="form-control @error('description') is-invalid @enderror"
                                      placeholder="Descripción del lugar, capacidad, estilo, etc. (opcional)">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Dirección --}}
                        <div class="mb-0">
                            <label for="address" class="form-label fw-semibold">Dirección</label>
                            <input type="text" id="address" name="address"
                                   class="form-control @error('address') is-invalid @enderror"
                                   value="{{ old('address') }}"
                                   placeholder="Calle y número">
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                </div>
            </div>

            {{-- Columna lateral --}}
            <div class="col-lg-4">
                {{-- Ubicación (componente Livewire) --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3">
                            <i class="bi bi-geo-alt me-1" style="color: var(--ht-magenta);"></i>
                            Ubicación
                        </h6>

                        @livewire('location-selector', [
                            'countryId' => old('country_id'),
                            'provinceId' => old('province_id'),
                            'cityId' => old('city_id'),
                        ])

                        {{-- Latitud --}}
                        <div class="mb-3 mt-3">
                            <label for="latitude" class="form-label fw-semibold">Latitud</label>
                            <input type="text" id="latitude" name="latitude"
                                   class="form-control @error('latitude') is-invalid @enderror"
                                   value="{{ old('latitude') }}"
                                   placeholder="-38.0055">
                            @error('latitude')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Opcional, para el mapa.</div>
                        </div>

                        {{-- Longitud --}}
                        <div class="mb-0">
                            <label for="longitude" class="form-label fw-semibold">Longitud</label>
                            <input type="text" id="longitude" name="longitude"
                                   class="form-control @error('longitude') is-invalid @enderror"
                                   value="{{ old('longitude') }}"
                                   placeholder="-57.5426">
                            @error('longitude')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Opcional, para el mapa.</div>
                        </div>
                    </div>
                </div>

                {{-- Portada --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3">
                            <i class="bi bi-image me-1" style="color: var(--ht-cyan);"></i>
                            Imagen principal
                        </h6>
                        <input type="file" id="cover" name="cover" accept="image/*"
                               class="form-control @error('cover') is-invalid @enderror">
                        @error('cover')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Opcional. Máx. 2MB.</div>
                    </div>
                </div>

                {{-- Galería --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3">
                            <i class="bi bi-images me-1" style="color: #b8a400;"></i>
                            Galería de fotos
                        </h6>
                        <input type="file" id="gallery" name="gallery[]" accept="image/*"
                               class="form-control @error('gallery') is-invalid @enderror" multiple>
                        @error('gallery')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Opcional. Puedes seleccionar varias imágenes.</div>
                    </div>
                </div>

                {{-- Redes sociales --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        @livewire('social-links-manager')
                    </div>
                </div>

                {{-- Botones --}}
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-dark rounded-pill">
                        <i class="bi bi-check-lg me-1"></i> Guardar lugar
                    </button>
                    <a href="{{ route('admin.venues.index') }}" class="btn btn-outline-secondary rounded-pill">
                        Cancelar
                    </a>
                </div>
            </div>
        </div>
    </form>
@endsection