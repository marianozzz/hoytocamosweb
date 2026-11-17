@extends('layouts.app')

@section('title', 'Editar perfil — HoyTocamos')

@section('content')
    <div class="container py-4">

        <div class="row justify-content-center">
            <div class="col-lg-8">

                {{-- Cabecera --}}
                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                    <div>
                        <h1 class="h3 fw-bold mb-1">Editar perfil</h1>
                        <p class="text-muted mb-0">Actualiza tus datos y tus gustos musicales.</p>
                    </div>
                    <a href="{{ route('profile.index') }}" class="btn btn-outline-secondary rounded-pill">
                        <i class="bi bi-arrow-left me-1"></i> Volver al perfil
                    </a>
                </div>

                {{-- Mensajes de éxito --}}
                @if (session('status'))
                    <div class="alert alert-success rounded-3" role="alert">
                        <i class="bi bi-check-circle me-1"></i> {{ session('status') }}
                    </div>
                @endif

                {{-- Formulario --}}
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Datos básicos --}}
                    <div class="ht-card ht-card-static mb-4">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3">
                                <i class="bi bi-person-circle me-2" style="color: var(--ht-magenta);"></i>
                                Datos básicos
                            </h5>

                            {{-- Avatar --}}
                            <div class="mb-3">
                                <label for="avatar" class="form-label fw-semibold">Foto de perfil</label>
                                <input type="file" id="avatar" name="avatar" accept="image/*"
                                       class="form-control @error('avatar') is-invalid @enderror">
                                @error('avatar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Máximo 2MB. Formatos: JPG, PNG, WebP.</div>
                            </div>

                            {{-- Nombre --}}
                            <div class="mb-3">
                                <label for="name" class="form-label fw-semibold">Nombre</label>
                                <input type="text" id="name" name="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="mb-0">
                                <label for="email" class="form-label fw-semibold">Correo electrónico</label>
                                <input type="email" id="email" name="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Ubicación (componente Livewire) --}}
                    <div class="ht-card ht-card-static mb-4">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3">
                                <i class="bi bi-geo-alt me-2" style="color: var(--ht-cyan);"></i>
                                Ubicación
                            </h5>

                            @livewire('location-selector', [
                                'countryId' => $user->country_id,
                                'provinceId' => $user->province_id,
                                'cityId' => $user->city_id,
                            ])
                        </div>
                    </div>

                    {{-- Gustos musicales --}}
                    <div class="ht-card ht-card-static mb-4">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-1">
                                <i class="bi bi-music-note-beamed me-2" style="color: var(--ht-cyan);"></i>
                                Gustos musicales
                            </h5>
                            <p class="text-muted small mb-3">
                                Selecciona los géneros que te gustan. Aparecerán en tu perfil público.
                            </p>

                            @php
                                $selected = old('genres', $user->genres->pluck('id')->toArray());
                            @endphp

                            <div class="row row-cols-2 row-cols-md-3 g-2">
                                @foreach ($allGenres as $genre)
                                    <div class="col">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                   name="genres[]" value="{{ $genre->id }}"
                                                   id="genre-{{ $genre->id }}"
                                                   {{ in_array($genre->id, $selected) ? 'checked' : '' }}>
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

                    {{-- Botones --}}
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('profile.index') }}" class="btn btn-outline-secondary rounded-pill">
                            Cancelar
                        </a>
                        <button type="submit" class="btn btn-ht-primary">
                            <i class="bi bi-check-lg me-1"></i> Guardar cambios
                        </button>
                    </div>
                </form>

            </div>
        </div>

    </div>
@endsection