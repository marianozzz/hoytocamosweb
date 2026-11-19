@extends('layouts.admin')

@section('title', 'Editar banda — Admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h1 class="h3 fw-bold mb-1">Editar banda o artista</h1>
            <p class="text-muted mb-0">Modifica los datos del proyecto.</p>
        </div>
        <a href="{{ route('admin.bands.show', $band) }}" class="btn btn-outline-secondary rounded-pill">
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

    <form method="POST" action="{{ route('admin.bands.update', $band) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

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
                                   value="{{ old('name', $band->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Slug (solo lectura) --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Slug actual</label>
                            <input type="text" class="form-control" value="{{ $band->slug }}" disabled readonly>
                            <div class="form-text">El slug se regenera automáticamente si cambias el nombre.</div>
                        </div>

                        {{-- Tipo de entidad --}}
                        <div class="mb-3">
                            <label for="entity_type_id" class="form-label fw-semibold">Tipo</label>
                            <select id="entity_type_id" name="entity_type_id"
                                    class="form-select @error('entity_type_id') is-invalid @enderror">
                                <option value="">Sin definir</option>
                                @foreach ($entityTypes as $type)
                                    <option value="{{ $type->id }}"
                                        {{ old('entity_type_id', $band->entity_type_id) == $type->id ? 'selected' : '' }}>
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
                                      placeholder="Descripción, historia, estilo... (opcional)">{{ old('bio', $band->bio) }}</textarea>
                            @error('bio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Fecha de formación --}}
                        <div class="mb-3">
                            <label for="founded_at" class="form-label fw-semibold">Fecha de formación</label>
                            <input type="date" id="founded_at" name="founded_at"
                                   class="form-control @error('founded_at') is-invalid @enderror"
                                   value="{{ old('founded_at', $band->founded_at?->format('Y-m-d')) }}">
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
                                $selectedGenres = old('genres', $band->genres->pluck('id')->toArray());
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
                            'countryId' => old('country_id', $band->country_id),
                            'provinceId' => old('province_id', $band->province_id),
                            'cityId' => old('city_id', $band->city_id),
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

                        @if ($band->coverUrl())
                            <div class="mb-3">
                                <img src="{{ $band->coverUrl() }}" alt="Portada actual"
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

                        @if ($band->galleryUrls())
                            <div class="row g-2 mb-3">
                                @foreach ($band->galleryUrls() as $url)
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
                                <option value="pending" {{ old('status', $band->status) == 'pending' ? 'selected' : '' }}>Pendiente</option>
                                <option value="approved" {{ old('status', $band->status) == 'approved' ? 'selected' : '' }}>Aprobada</option>
                                <option value="rejected" {{ old('status', $band->status) == 'rejected' ? 'selected' : '' }}>Rechazada</option>
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
                        @livewire('social-links-manager', [
                            'linkableId' => $band->id,
                            'linkableType' => \App\Models\Band::class,
                        ])
                    </div>
                </div>

                {{-- Botones --}}
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-dark rounded-pill">
                        <i class="bi bi-check-lg me-1"></i> Guardar cambios
                    </button>
                    <a href="{{ route('admin.bands.index') }}" class="btn btn-outline-secondary rounded-pill">
                        Cancelar
                    </a>
                </div>
            </div>
        </div>
    </form>
@endsection