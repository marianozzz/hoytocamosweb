@extends('layouts.admin')

@section('title', 'Editar post — Admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h1 class="h3 fw-bold mb-1">Editar post</h1>
            <p class="text-muted mb-0">Modifica los datos de la noticia.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.posts.show', $post) }}" class="btn btn-outline-secondary rounded-pill">
                <i class="bi bi-arrow-left me-1"></i> Volver al detalle
            </a>
        </div>
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

    <form method="POST" action="{{ route('admin.posts.update', $post) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-4">
            {{-- Columna principal --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">

                        {{-- Título --}}
                        <div class="mb-3">
                            <label for="title" class="form-label fw-semibold">Título</label>
                            <input type="text" id="title" name="title"
                                   class="form-control @error('title') is-invalid @enderror"
                                   value="{{ old('title', $post->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Slug (solo lectura) --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Slug actual</label>
                            <input type="text" class="form-control" value="{{ $post->slug }}" disabled readonly>
                            <div class="form-text">El slug se regenera automáticamente si cambias el título.</div>
                        </div>

                        {{-- Extracto --}}
                        <div class="mb-3">
                            <label for="excerpt" class="form-label fw-semibold">Extracto</label>
                            <textarea id="excerpt" name="excerpt" rows="3"
                                      class="form-control @error('excerpt') is-invalid @enderror"
                                      placeholder="Resumen corto que aparecerá en el listado (opcional)">{{ old('excerpt', $post->excerpt) }}</textarea>
                            @error('excerpt')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Cuerpo con TinyMCE --}}
                        <div class="mb-0">
                            <label for="body" class="form-label fw-semibold">Contenido</label>
                            <textarea id="body" name="body" rows="15"
                                      class="form-control @error('body') is-invalid @enderror">{{ old('body', $post->body) }}</textarea>
                            @error('body')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                </div>
            </div>

            {{-- Columna lateral --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">

                        <h6 class="fw-bold mb-3">
                            <i class="bi bi-gear me-1" style="color: var(--ht-magenta);"></i>
                            Publicación
                        </h6>

                        {{-- Estado --}}
                        <div class="mb-3">
                            <label for="published" class="form-label fw-semibold">Estado</label>
                            <select id="published" name="published"
                                    class="form-select @error('published') is-invalid @enderror">
                                <option value="0" {{ old('published', $post->published) == '0' ? 'selected' : '' }}>Borrador</option>
                                <option value="1" {{ old('published', $post->published) == '1' ? 'selected' : '' }}>Publicado</option>
                            </select>
                            @error('published')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Fecha de publicación --}}
                        <div class="mb-0">
                            <label for="published_at" class="form-label fw-semibold">Fecha de publicación</label>
                            <input type="datetime-local" id="published_at" name="published_at"
                                   class="form-control @error('published_at') is-invalid @enderror"
                                   value="{{ old('published_at', $post->published_at?->format('Y-m-d\TH:i')) }}">
                            @error('published_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                </div>

                {{-- Portada --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3">
                            <i class="bi bi-image me-1" style="color: var(--ht-cyan);"></i>
                            Imagen de portada
                        </h6>

                        @if ($post->coverUrl())
                            <div class="mb-3">
                                <img src="{{ $post->coverUrl() }}" alt="Portada actual"
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

                {{-- Botones --}}
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-dark rounded-pill">
                        <i class="bi bi-check-lg me-1"></i> Guardar cambios
                    </button>
                    <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-secondary rounded-pill">
                        Cancelar
                    </a>
                </div>
            </div>
        </div>
    </form>

    {{-- TinyMCE --}}
    <script src="{{ asset('js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#body',
            license_key: 'gpl',
            height: 500,
            menubar: false,
            plugins: 'code table lists link image',
            toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | link image | code | table',
            promotion: false
        });
    </script>
@endsection