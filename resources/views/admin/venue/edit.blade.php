@extends('layouts.admin')

@section('title', 'Editar lugar — Admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h1 class="h3 fw-bold mb-1">Editar lugar</h1>
            <p class="text-muted mb-0">Modifica los datos del espacio.</p>
        </div>
        <a href="{{ route('admin.venues.show', $venue) }}" class="btn btn-outline-secondary rounded-pill">
            <i class="bi bi-arrow-left me-1"></i> Volver al detalle
        </a>
    </div>

    {{-- Errores generales --}}
    @if ($errors->any())
        <div class="alert alert-danger rounded-3" role="alert">
            <i class="bi bi-exclamation-triangle me-1"></i>
            Revisa los campos marcados en rojo.
        </div>
    @endif

    {{-- Mensaje de éxito --}}
    @if (session('status'))
        <div class="alert alert-success rounded-3" role="alert">
            <i class="bi bi-check-circle me-1"></i> {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.venues.update', $venue) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

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
                                   value="{{ old('name', $venue->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Slug (solo lectura) --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Slug actual</label>
                            <input type="text" class="form-control" value="{{ $venue->slug }}" disabled readonly>
                            <div class="form-text">El slug se regenera automáticamente si cambias el nombre.</div>
                        </div>

                        {{-- Descripción --}}
                        <div class="mb-3">
                            <label for="description" class="form-label fw-semibold">Descripción</label>
                            <textarea id="description" name="description" rows="5"
                                      class="form-control @error('description') is-invalid @enderror"
                                      placeholder="Descripción del lugar, capacidad, estilo, etc. (opcional)">{{ old('description', $venue->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Dirección --}}
                        <div class="mb-0">
                            <label for="address" class="form-label fw-semibold">Dirección</label>
                            <input type="text" id="address" name="address"
                                   class="form-control @error('address') is-invalid @enderror"
                                   value="{{ old('address', $venue->address) }}"
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
                            'countryId' => old('country_id', $venue->city?->province?->country_id),
                            'provinceId' => old('province_id', $venue->city?->province_id),
                            'cityId' => old('city_id', $venue->city_id),
                        ])

                        {{-- Latitud --}}
                        <div class="mb-3 mt-3">
                            <label for="latitude" class="form-label fw-semibold">Latitud</label>
                            <input type="text" id="latitude" name="latitude"
                                   class="form-control @error('latitude') is-invalid @enderror"
                                   value="{{ old('latitude', $venue->latitude) }}"
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
                                   value="{{ old('longitude', $venue->longitude) }}"
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

                        @if ($venue->coverUrl())
                            <div class="mb-3">
                                <img src="{{ $venue->coverUrl() }}" alt="Portada actual"
                                     class="img-fluid rounded-3 w-100"
                                     style="max-height: 160px; object-fit: cover;">
                                <div class="form-text mt-1">Portada actual</div>
                            </div>
                        @endif

                        <input type="file" id="cover" name="cover" accept="image/*"
                               class="form-control @error('cover') is-invalid @enderror">
                        @error('cover')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Sube una nueva para reemplazar la actual.</div>
                    </div>
                </div>

                {{-- Galería --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3">
                            <i class="bi bi-images me-1" style="color: #b8a400;"></i>
                            Galería de fotos
                        </h6>

                        @if ($venue->galleryUrls())
                            <div class="row g-2 mb-3">
                                @foreach ($venue->galleryUrls() as $url)
                                    <div class="col-4">
                                        <img src="{{ $url }}" alt="Imagen de galería"
                                             class="img-fluid rounded-2 w-100"
                                             style="height: 80px; object-fit: cover;">
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <input type="file" id="gallery" name="gallery[]" accept="image/*"
                               class="form-control @error('gallery') is-invalid @enderror" multiple>
                        @error('gallery')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Sube nuevas imágenes para añadir a la galería.</div>
                    </div>
                </div>

                {{-- Redes sociales --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        @livewire('social-links-manager', [
                            'linkableId' => $venue->id,
                            'linkableType' => \App\Models\Venue::class,
                        ])
                    </div>
                </div>

                {{-- Botones --}}
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-dark rounded-pill">
                        <i class="bi bi-check-lg me-1"></i> Guardar cambios
                    </button>
                    <a href="{{ route('admin.venues.index') }}" class="btn btn-outline-secondary rounded-pill">
                        Cancelar
                    </a>
                </div>
            </div>
        </div>
    </form>
@endsection