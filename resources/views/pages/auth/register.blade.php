<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Crear cuenta — HoyTocamos</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --ht-dark: #0d0d12;
            --ht-dark-2: #15151d;
            --ht-magenta: #e6007e;
            --ht-magenta-soft: #ff3d9a;
            --ht-yellow: #ffe600;
            --ht-cyan: #00e0d0;
        }

        body {
            font-family: 'Space Grotesk', system-ui, -apple-system, sans-serif;
            background:
                radial-gradient(circle at 80% 20%, rgba(230, 0, 126, 0.45), transparent 55%),
                radial-gradient(circle at 10% 80%, rgba(0, 224, 208, 0.25), transparent 50%),
                linear-gradient(135deg, var(--ht-dark) 0%, var(--ht-dark-2) 100%);
            color: #fff;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        body::after {
            content: "";
            position: fixed;
            inset: 0;
            background-image: repeating-linear-gradient(
                45deg,
                rgba(255, 255, 255, 0.03) 0px,
                rgba(255, 255, 255, 0.03) 1px,
                transparent 1px,
                transparent 12px
            );
            pointer-events: none;
        }

        .ht-auth-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
            position: relative;
            z-index: 1;
        }

        .ht-auth-card {
            background: #fff;
            color: #1a1a1a;
            border-radius: 20px;
            box-shadow: 0 24px 80px rgba(230, 0, 126, 0.25);
            width: 100%;
            max-width: 480px;
            overflow: hidden;
            position: relative;
        }

        .ht-auth-card::before {
            content: "";
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 6px;
            background: linear-gradient(90deg, var(--ht-magenta), var(--ht-yellow));
        }

        .ht-auth-body {
            padding: 2.5rem 2rem 2rem;
        }

        .ht-brand {
            font-weight: 700;
            letter-spacing: .02em;
            font-size: 1.5rem;
            text-align: center;
            margin-bottom: .25rem;
            color: var(--ht-dark);
        }
        .ht-brand span { color: var(--ht-magenta); }

        .ht-auth-title {
            font-weight: 700;
            font-size: 1.35rem;
            text-align: center;
            margin-bottom: .5rem;
        }

        .ht-auth-desc {
            color: #6b6b6b;
            text-align: center;
            font-size: .95rem;
            margin-bottom: 1.75rem;
        }

        .form-label {
            font-weight: 600;
            font-size: .875rem;
            color: #1a1a1a;
        }

        .form-control {
            border-radius: 12px;
            padding: .75rem 1rem;
            border: 1.5px solid #e3e3e3;
            font-size: .95rem;
            transition: all .2s ease;
        }
        .form-control:focus {
            border-color: var(--ht-magenta);
            box-shadow: 0 0 0 .2rem rgba(230, 0, 126, 0.15);
        }

        .btn-ht-primary {
            background: var(--ht-magenta);
            border: none;
            color: #fff;
            font-weight: 600;
            padding: .8rem 1.75rem;
            border-radius: 999px;
            transition: all .2s ease;
            box-shadow: 0 8px 24px rgba(230, 0, 126, 0.35);
            width: 100%;
        }
        .btn-ht-primary:hover {
            background: var(--ht-magenta-soft);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(230, 0, 126, 0.5);
        }

        .ht-link {
            color: var(--ht-magenta);
            text-decoration: none;
            font-weight: 500;
        }
        .ht-link:hover {
            color: var(--ht-magenta-soft);
            text-decoration: underline;
        }

        .ht-footer-note {
            text-align: center;
            font-size: .9rem;
            color: #6b6b6b;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #f0f0f0;
        }

        .invalid-feedback { font-size: .85rem; }
        .alert-danger {
            background: #fff2f5;
            border: 1px solid #ffccd9;
            color: #a3003f;
            border-radius: 12px;
            font-size: .9rem;
        }

        .ht-status {
            background: #e8fff5;
            border: 1px solid #b8f0d5;
            color: #00603a;
            border-radius: 12px;
            padding: .75rem 1rem;
            font-size: .9rem;
            text-align: center;
            margin-bottom: 1.25rem;
        }

        .ht-hint {
            font-size: .8rem;
            color: #8a8a8a;
            margin-top: .35rem;
        }
    </style>
</head>
<body>

    <div class="ht-auth-wrapper">
        <div class="ht-auth-card">
            <div class="ht-auth-body">

                {{-- Marca --}}
                <div class="ht-brand">
                    Hoy<span>Tocamos</span>
                </div>

                {{-- Título --}}
                <h1 class="ht-auth-title">Crea tu cuenta</h1>
                <p class="ht-auth-desc">Completa tus datos para empezar a publicar y seguir la escena.</p>

                {{-- Mensaje de estado de sesión --}}
                @if (session('status'))
                    <div class="ht-status">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('register.store') }}">
                    @csrf

                    {{-- Name --}}
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre</label>
                        <input
                            type="text"
                            class="form-control @error('name') is-invalid @enderror"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            required
                            autofocus
                            autocomplete="name"
                            placeholder="Tu nombre completo"
                        >
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo electrónico</label>
                        <input
                            type="email"
                            class="form-control @error('email') is-invalid @enderror"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autocomplete="email"
                            placeholder="email@example.com"
                        >
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input
                            type="password"
                            class="form-control @error('password') is-invalid @enderror"
                            id="password"
                            name="password"
                            required
                            autocomplete="new-password"
                            placeholder="Tu contraseña"
                            passwordrules="{{ \Illuminate\Validation\Rules\Password::defaults()->toPasswordRulesString() }}"
                        >
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="ht-hint">Mínimo 8 caracteres. Recomendamos mezclar letras, números y símbolos.</div>
                    </div>

                    {{-- Confirm Password --}}
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirmar contraseña</label>
                        <input
                            type="password"
                            class="form-control @error('password_confirmation') is-invalid @enderror"
                            id="password_confirmation"
                            name="password_confirmation"
                            required
                            autocomplete="new-password"
                            placeholder="Repite tu contraseña"
                            passwordrules="{{ \Illuminate\Validation\Rules\Password::defaults()->toPasswordRulesString() }}"
                        >
                        @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Submit --}}
                    <button type="submit" class="btn btn-ht-primary" data-test="register-user-button">
                        Crear cuenta
                    </button>
                </form>

                {{-- Enlace a login --}}
                <div class="ht-footer-note">
                    ¿Ya tienes cuenta?
                    <a href="{{ route('login') }}" class="ht-link">Inicia sesión</a>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>