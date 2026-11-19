@extends('layouts.admin')

@section('title', 'Editar plataforma — Admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h1 class="h3 fw-bold mb-1">Editar plataforma</h1>
            <p class="text-muted mb-0">Modifica los datos de la red social.</p>
        </div>
        <a href="{{ route('admin.social-platforms.index') }}" class="btn btn-outline-secondary rounded-pill">
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

    {{-- Mensaje de éxito --}}
    @if (session('status'))
        <div class="alert alert-success rounded-3" role="alert">
            <i class="bi bi-check-circle me-1"></i> {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.social-platforms.update', $socialPlatform) }}">
        @csrf
        @method('PUT')

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">

                        {{-- Nombre --}}
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">Nombre</label>
                            <input type="text" id="name" name="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $socialPlatform->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Slug (solo lectura) --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Slug actual</label>
                            <input type="text" class="form-control" value="{{ $socialPlatform->slug }}" disabled readonly>
                            <div class="form-text">El slug se regenera automáticamente si cambias el nombre.</div>
                        </div>

                        {{-- Icono --}}
                        <div class="mb-3">
                            <label for="icon" class="form-label fw-semibold">Icono (Bootstrap Icons)</label>
                            <input type="text" id="icon" name="icon"
                                   class="form-control @error('icon') is-invalid @enderror"
                                   value="{{ old('icon', $socialPlatform->icon) }}"
                                   placeholder="bi-instagram">
                            @error('icon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                Clase de Bootstrap Icons, por ejemplo <code>bi-instagram</code>,
                                <code>bi-facebook</code>, <code>bi-globe</code>.
                            </div>
                        </div>

                        {{-- URL base --}}
                        <div class="mb-3">
                            <label for="base_url" class="form-label fw-semibold">URL base</label>
                            <input type="text" id="base_url" name="base_url"
                                   class="form-control @error('base_url') is-invalid @enderror"
                                   value="{{ old('base_url', $socialPlatform->base_url) }}"
                                   placeholder="https://instagram.com/">
                            @error('base_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                Opcional. Se usa para validar o autocompletar los enlaces.
                            </div>
                        </div>

                        {{-- Estado --}}
                        <div class="mb-0">
                            <label for="active" class="form-label fw-semibold">Estado</label>
                            <select id="active" name="active"
                                    class="form-select @error('active') is-invalid @enderror">
                                <option value="1" {{ old('active', $socialPlatform->active) == '1' ? 'selected' : '' }}>Activa</option>
                                <option value="0" {{ old('active', $socialPlatform->active) == '0' ? 'selected' : '' }}>Inactiva</option>
                            </select>
                            @error('active')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                </div>
            </div>

            {{-- Columna lateral --}}
            <div class="col-lg-4">
                {{-- Vista previa del icono --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4 text-center">
                        <h6 class="fw-bold mb-3">
                            <i class="bi bi-eye me-1" style="color: var(--ht-cyan);"></i>
                            Vista previa
                        </h6>
                        <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center mb-3"
                             style="width: 72px; height: 72px;">
                            <i class="{{ $socialPlatform->icon ?? 'bi bi-share text-muted' }} fs-2" id="icon-preview"></i>
                        </div>
                        <p class="text-muted small mb-0">
                            El icono se actualizará al escribir la clase.
                        </p>
                    </div>
                </div>

                {{-- Botones --}}
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-dark rounded-pill">
                        <i class="bi bi-check-lg me-1"></i> Guardar cambios
                    </button>
                    <a href="{{ route('admin.social-platforms.index') }}" class="btn btn-outline-secondary rounded-pill">
                        Cancelar
                    </a>
                </div>
            </div>
        </div>
    </form>

    {{-- Vista previa dinámica del icono --}}
    <script>
        const iconInput = document.getElementById('icon');
        const iconPreview = document.getElementById('icon-preview');

        iconInput.addEventListener('input', () => {
            const value = iconInput.value.trim();
            iconPreview.className = 'bi fs-2 ' + (value || 'bi-share text-muted');
        });
    </script>
@endsection