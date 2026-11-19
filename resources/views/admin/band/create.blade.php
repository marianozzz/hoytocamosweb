@extends('layouts.admin')

@section('title', 'Nueva banda — Admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h1 class="h3 fw-bold mb-1">Nueva banda o artista</h1>
            <p class="text-muted mb-0">Carga una banda, artista solista, pintor o cualquier proyecto de la escena.</p>
        </div>
        <a href="{{ route('admin.bands.index') }}" class="btn btn-outline-secondary rounded-pill">
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

    <form method="POST" action="{{ route('admin.bands.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="row g-4">
            {{-- Columna principal --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">

                        {{-- Nombre --}}
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">Nombre</label>
                            <input type="text" id="name" name="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name') }}"
                                   placeholder="Nombre de la banda, artista o proyecto" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Tipo de entidad --}}
                        <div class="mb-3">
                            <label for="entity_type_id" class="form-label fw-semibold">Tipo</label>
                            <select id="entity_type_id" name="entity_type_id"
                                    class="form-select @error('entity_type_id') is-invalid @enderror">
                                <option value="">Sin definir</option>
                                @foreach ($entityTypes as $type)
                                    <option value="{{ $type->id }}"
                                        {{ old('entity_type_id') == $type->id ? 'selected' : '' }}>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('entity_type_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Bio --}}
                        <div class="mb-3">
                            <label for="bio" class="form-label fw-semibold">Biografía</label>
                            <textarea id="bio" name="bio" rows="5"
                                      class="form-control @error('bio') is-invalid @enderror"
                                      placeholder="Descripción, historia, estilo... (opcional)">{{ old('bio') }}</textarea>
                            @error('bio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Fecha de formación --}}
                        <div class="mb-3">
                            <label for="founded_at" class="form-label fw-semibold">Fecha de formación</label>
                            <input type="date" id="founded_at" name="founded_at"
                                   class="form-control @error('founded_at') is-invalid @enderror"
                                   value="{{ old('founded_at') }}">
                            @error('founded_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Opcional.</div>
                        </div>

                        {{-- Géneros --}}
                        <div class="mb-0">
                            <label class="form-label fw-semibold">Géneros / disciplinas</label>
                            <p class="text-muted small mb-2">Selecciona los géneros o disciplinas que practica.</p>
                            @php
                                $selectedGenres = old('genres', []);
                            @endphp
                            <div class="row row-cols-2 row-cols-md-3 g-2">
                                @foreach ($genres as $genre)
                                    <div class="col">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                   name="genres[]" value="{{ $genre->id }}"
                                                   id="genre-{{ $genre->id }}"
                                                   {{ in_array($genre->id, $selectedGenres) ? 'checked' : '' }}>
                                            <label class="form-check-label small" for="genre-{{ $genre->id }}">
                                                {{ $genre->name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @error('genres')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                </div>
            </div>

            {{-- Columna lateral --}}
            <div class="col-lg-4">
                {{-- Origen (componente Livewire) --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3">
                            <i class="bi bi-geo-alt me-1" style="color: var(--ht-magenta);"></i>
                            Origen
                        </h6>

                        @livewire('location-selector', [
                            'countryId' => old('country_id'),
                            'provinceId' => old('province_id'),
                            'cityId' => old('city_id'),
                        ])
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

                {{-- Estado --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3">
                            <i class="bi bi-gear me-1" style="color: var(--ht-magenta);"></i>
                            Publicación
                        </h6>
                        <div class="mb-0">
                            <label for="status" class="form-label fw-semibold">Estado</label>
                            <select id="status" name="status"
                                    class="form-select @error('status') is-invalid @enderror">
                                <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>Pendiente</option>
                                <option value="approved" {{ old('status') == 'approved' ? 'selected' : '' }}>Aprobada</option>
                                <option value="rejected" {{ old('status') == 'rejected' ? 'selected' : '' }}>Rechazada</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
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
                        <i class="bi bi-check-lg me-1"></i> Guardar banda
                    </button>
                    <a href="{{ route('admin.bands.index') }}" class="btn btn-outline-secondary rounded-pill">
                        Cancelar
                    </a>
                </div>
            </div>
        </div>
    </form>
@endsection