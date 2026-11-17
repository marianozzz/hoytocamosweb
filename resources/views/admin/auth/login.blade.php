<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Admin — HoyTocamos</title>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-5 col-lg-4">

                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4 p-md-5">

                        {{-- Logo / Título --}}
                        <div class="text-center mb-4">
                            <h1 class="h3 fw-bold mb-1">HoyTocamos</h1>
                            <p class="text-muted small mb-0">Panel de Administración</p>
                        </div>

                        {{-- Errores generales --}}
                        @if ($errors->any())
                            <div class="alert alert-danger rounded-3 small">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        {{-- Formulario --}}
                        <form method="POST" action="{{ route('admin.login.attempt') }}">
                            @csrf

                            {{-- Email --}}
                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">Correo electrónico</label>
                                <input type="email" id="email" name="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email') }}" required autofocus>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Password --}}
                            <div class="mb-3">
                                <label for="password" class="form-label fw-semibold">Contraseña</label>
                                <input type="password" id="password" name="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Recordarme --}}
                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                <label class="form-check-label small" for="remember">
                                    Recordarme
                                </label>
                            </div>

                            {{-- Botón --}}
                            <button type="submit" class="btn btn-dark w-100 rounded-pill">
                                <i class="bi bi-box-arrow-in-right me-1"></i> Entrar al panel
                            </button>
                        </form>

                        {{-- Volver al sitio --}}
                        <div class="text-center mt-4">
                            <a href="{{ route('home') }}" class="small text-muted text-decoration-none">
                                <i class="bi bi-arrow-left me-1"></i> Volver al sitio
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</body>
</html>