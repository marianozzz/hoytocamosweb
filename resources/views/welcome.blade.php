<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>HoyTocamos — El calendario de la escena under</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;700&display=swap" rel="stylesheet">

    {{-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) --}}

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
            background-color: #f6f4ef;
            color: #1a1a1a;
        }

        .ht-hero {
            background:
                radial-gradient(circle at 80% 20%, rgba(230, 0, 126, 0.45), transparent 55%),
                radial-gradient(circle at 10% 80%, rgba(0, 224, 208, 0.25), transparent 50%),
                linear-gradient(135deg, var(--ht-dark) 0%, var(--ht-dark-2) 100%);
            color: #fff;
            position: relative;
            overflow: hidden;
        }
        .ht-hero::after {
            content: "";
            position: absolute;
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
        .ht-hero h1 {
            font-weight: 700;
            letter-spacing: -0.02em;
            text-shadow: 0 0 40px rgba(230, 0, 126, 0.5);
        }

        .ht-badge-live {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            background: rgba(255, 230, 0, 0.12);
            color: var(--ht-yellow);
            border: 1px solid rgba(255, 230, 0, 0.4);
            padding: .35rem .9rem;
            border-radius: 999px;
            font-size: .8rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: .08em;
        }
        .ht-badge-live .dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--ht-yellow);
            animation: pulse 1.5s infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: .4; transform: scale(.8); }
        }

        .btn-ht-primary {
            background: var(--ht-magenta);
            border: none;
            color: #fff;
            font-weight: 600;
            padding: .75rem 1.75rem;
            border-radius: 999px;
            transition: all .2s ease;
            box-shadow: 0 8px 24px rgba(230, 0, 126, 0.35);
        }
        .btn-ht-primary:hover {
            background: var(--ht-magenta-soft);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(230, 0, 126, 0.5);
        }

        .btn-ht-ghost {
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.4);
            color: #fff;
            font-weight: 500;
            padding: .75rem 1.75rem;
            border-radius: 999px;
            transition: all .2s ease;
        }
        .btn-ht-ghost:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            border-color: #fff;
        }

        .ht-card {
            border: none;
            border-radius: 18px;
            background: #fff;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.06);
            transition: transform .25s ease, box-shadow .25s ease;
            overflow: hidden;
            position: relative;
        }
        .ht-card::before {
            content: "";
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 6px;
            background: linear-gradient(90deg, var(--ht-magenta), var(--ht-yellow));
        }
        .ht-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 16px 40px rgba(230, 0, 126, 0.18);
        }

        .ht-date-badge {
            display: inline-block;
            background: var(--ht-dark);
            color: #fff;
            padding: .3rem .8rem;
            border-radius: 8px;
            font-size: .75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .05em;
        }

        .ht-venue {
            color: var(--ht-magenta);
            font-weight: 600;
            font-size: .9rem;
        }

        .ht-news {
            background: #fff;
            border-radius: 14px;
            border-left: 6px solid var(--ht-cyan);
            padding: 1.25rem;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.05);
            transition: transform .2s ease;
        }
        .ht-news:hover {
            transform: translateX(4px);
        }
        .ht-news:nth-child(2) { border-left-color: var(--ht-yellow); }

        .ht-section-title {
            font-weight: 700;
            letter-spacing: -0.01em;
            position: relative;
            display: inline-block;
        }
        .ht-section-title::after {
            content: "";
            display: block;
            width: 60px;
            height: 4px;
            background: var(--ht-magenta);
            border-radius: 2px;
            margin-top: .5rem;
        }

        .ht-cta {
            background:
                radial-gradient(circle at 85% 15%, rgba(230, 0, 126, 0.55), transparent 55%),
                radial-gradient(circle at 15% 85%, rgba(0, 224, 208, 0.35), transparent 50%),
                linear-gradient(135deg, var(--ht-dark) 0%, var(--ht-dark-2) 100%);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        .ht-cta::after {
            content: "";
            position: absolute;
            inset: 0;
            background-image: repeating-linear-gradient(
                -45deg,
                rgba(255, 255, 255, 0.025) 0px,
                rgba(255, 255, 255, 0.025) 1px,
                transparent 1px,
                transparent 14px
            );
            pointer-events: none;
        }
    </style>
</head>
<body>

    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-dark" style="background: var(--ht-dark);">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ url('/') }}" style="letter-spacing: .02em;">
                Hoy<span style="color: var(--ht-magenta);">Tocamos</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#mainNav" aria-controls="mainNav"
                    aria-expanded="false" aria-label="Alternar navegación">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="#eventos">Eventos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('posts.index') }}">Noticias</a>
                    </li>
                </ul>

                <div class="d-flex gap-2">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-ht-primary btn-sm">
                            Mi panel
                        </a>
                    @else
                        @if (Route::has('login'))
                            <a href="{{ route('login') }}" class="btn btn-ht-ghost btn-sm">
                                Iniciar sesión
                            </a>
                        @endif
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-ht-primary btn-sm">
                                Registrarse
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- Hero --}}
    <header class="ht-hero py-5 py-lg-5">
        <div class="container py-4 py-lg-5 position-relative" style="z-index: 1;">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <span class="ht-badge-live mb-3">
                        <span class="dot"></span> La escena en vivo
                    </span>
                    <h1 class="display-4 mb-3">
                        Hoy <span style="color: var(--ht-yellow);">tocamos</span>.<br>
                        Y tú no te lo puedes perder.
                    </h1>
                    <p class="lead mb-4" style="max-width: 540px; color: rgba(255,255,255,.8);">
                        El calendario de la escena under. Descubre qué bandas tocan hoy,
                        encuentra nuevos lugares y no te pierdas ningún evento cultural.
                    </p>

                    @guest
                        <div class="d-flex flex-wrap gap-2">
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-ht-primary btn-lg">
                                    Crear cuenta
                                </a>
                            @endif
                            @if (Route::has('login'))
                                <a href="{{ route('login') }}" class="btn btn-ht-ghost btn-lg">
                                    Ya tengo cuenta
                                </a>
                            @endif
                        </div>
                        <p class="mt-3 mb-0 small" style="color: rgba(255,255,255,.55);">
                            Como invitado puedes explorar fechas y noticias.
                            Regístrate para publicar tus propios eventos.
                        </p>
                    @endguest

                    @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-ht-primary btn-lg">
                            Ir a mi panel
                        </a>
                        <p class="mt-3 mb-0 small" style="color: rgba(255,255,255,.55);">
                            Bienvenido de nuevo. Aquí podrás gestionar tus fechas.
                        </p>
                    @endauth
                </div>
                <div class="col-lg-4 text-center d-none d-lg-block">
                    <div class="display-1" style="font-size: 9rem; opacity: .9; filter: drop-shadow(0 0 40px rgba(230,0,126,.6));">
                        🎸
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="container py-5">

        {{-- Próximas fechas (maqueta estática) --}}
        <section id="eventos" class="mb-5">
            <div class="d-flex justify-content-between align-items-end mb-4 flex-wrap gap-2">
                <div>
                    <h2 class="ht-section-title h3 mb-0">Próximas fechas</h2>
                    <p class="text-muted mb-0 mt-3">Una muestra de lo que está por venir en la comunidad.</p>
                </div>
                <span class="badge rounded-pill" style="background: var(--ht-dark); color: var(--ht-yellow);">
                    Maqueta
                </span>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="ht-card h-100">
                        <div class="card-body p-4">
                            <span class="ht-date-badge mb-3">Viernes 15 Nov</span>
                            <h5 class="card-title fw-bold mt-3">Noche de Rock Local</h5>
                            <p class="ht-venue mb-2">📍 Bar El Sótano</p>
                            <p class="card-text text-muted">
                                Bandas: Los Ruidos, The Voids, Marea Baja.
                                Entrada libre hasta las 21:00.
                            </p>
                        </div>
                        <div class="card-footer bg-transparent border-top-0 pb-3 px-4">
                            <a href="#" class="btn btn-sm btn-outline-dark rounded-pill disabled">Ver detalles (Pronto)</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="ht-card h-100">
                        <div class="card-body p-4">
                            <span class="ht-date-badge mb-3">Sábado 16 Nov</span>
                            <h5 class="card-title fw-bold mt-3">Festival Under</h5>
                            <p class="ht-venue mb-2">📍 Espacio Cultural Nova</p>
                            <p class="card-text text-muted">
                                Evento al aire libre con 5 bandas invitadas.
                                Habrá feria de fanzines y comida.
                            </p>
                        </div>
                        <div class="card-footer bg-transparent border-top-0 pb-3 px-4">
                            <a href="#" class="btn btn-sm btn-outline-dark rounded-pill disabled">Ver detalles (Pronto)</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="ht-card h-100">
                        <div class="card-body p-4">
                            <span class="ht-date-badge mb-3">Domingo 17 Nov</span>
                            <h5 class="card-title fw-bold mt-3">Acústico de Tarde</h5>
                            <p class="ht-venue mb-2">📍 Café La Grieta</p>
                            <p class="card-text text-muted">
                                Sesión íntima con artistas locales.
                                Aforo limitado, llega temprano.
                            </p>
                        </div>
                        <div class="card-footer bg-transparent border-top-0 pb-3 px-4">
                            <a href="#" class="btn btn-sm btn-outline-dark rounded-pill disabled">Ver detalles (Pronto)</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Noticias (desde la BD) --}}
        <section id="noticias" class="mb-5">
            <div class="d-flex justify-content-between align-items-end mb-4 flex-wrap gap-2">
                <div>
                    <h2 class="ht-section-title h3 mb-0">Noticias de la escena</h2>
                    <p class="text-muted mb-0 mt-3">Novedades, convocatorias y espacios nuevos.</p>
                </div>
                <a href="{{ route('posts.index') }}" class="btn btn-sm btn-outline-dark rounded-pill">
                    Ver todas <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>

            <div class="row g-3">
                @forelse ($posts as $post)
                    <div class="col-md-6">
                        <div class="ht-news h-100">
                            <h6 class="fw-bold mb-1">{{ $post->title }}</h6>
                            <p class="text-muted small mb-2">
                                {{ $post->published_at?->format('d M Y') }}
                            </p>
                            <p class="mb-2">
                                {{ $post->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($post->body), 120) }}
                            </p>
                            <a href="{{ route('posts.show', $post->slug) }}"
                               class="small fw-semibold text-decoration-none"
                               style="color: var(--ht-magenta);">
                                Leer más <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="ht-news">
                            <p class="text-muted mb-0">Aún no hay noticias publicadas.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </section>

        {{-- CTA --}}
        <section class="ht-cta rounded-4 overflow-hidden position-relative my-5">
            <div class="row g-0 align-items-center">
                <div class="col-lg-7 p-4 p-lg-5 position-relative" style="z-index: 1;">
                    <span class="ht-badge-live mb-3">
                        <span class="dot"></span> Únete a la escena
                    </span>
                    <h2 class="display-6 fw-bold mb-3" style="color: #fff;">
                        Forma parte de la comunidad.<br>
                        <span style="color: var(--ht-yellow);">Entérate primero</span> de las novedades.
                    </h2>
                    <p class="mb-4" style="color: rgba(255,255,255,.75); max-width: 520px;">
                        Publica tus fechas, guarda tus eventos favoritos y recibe avisos
                        de nuevas tocadas antes que nadie. Sin algoritmos, sin ruido:
                        solo la escena que te importa.
                    </p>

                    @guest
                        <div class="d-flex flex-wrap gap-2 mb-3">
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-ht-primary btn-lg">
                                    Crear mi cuenta gratis
                                </a>
                            @endif
                            @if (Route::has('login'))
                                <a href="{{ route('login') }}" class="btn btn-ht-ghost btn-lg">
                                    Ya tengo cuenta
                                </a>
                            @endif
                        </div>
                        <ul class="list-unstyled small mb-0" style="color: rgba(255,255,255,.6);">
                            <li class="mb-1">✓ Publicar eventos es gratis</li>
                            <li class="mb-1">✓ Avisos de nuevas fechas en tu ciudad</li>
                            <li>✓ Tu perfil de banda u organizador, siempre visible</li>
                        </ul>
                    @endguest

                    @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-ht-primary btn-lg">
                            Ir a mi panel
                        </a>
                        <p class="mt-3 mb-0 small" style="color: rgba(255,255,255,.6);">
                            Ya eres parte de la comunidad. Gracias por estar.
                        </p>
                    @endauth
                </div>

                <div class="col-lg-5 d-none d-lg-flex align-items-center justify-content-center p-4 position-relative" style="z-index: 1;">
                    <div class="text-center">
                        <div style="font-size: 7rem; line-height: 1; filter: drop-shadow(0 0 40px rgba(255,230,0,.5));">
                            🤘
                        </div>
                        <p class="mt-3 mb-0 small text-uppercase" style="color: rgba(255,255,255,.5); letter-spacing: .15em;">
                            La escena te espera
                        </p>
                    </div>
                </div>
            </div>
        </section>

    </main>

    {{-- Footer --}}
    <footer class="py-4 mt-auto" style="background: var(--ht-dark); color: rgba(255,255,255,.6);">
        <div class="container d-flex flex-column flex-md-row justify-content-between gap-2">
            <span>&copy; {{ date('Y') }} HoyTocamos</span>
            <span class="small">Hecho para la escena under.</span>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @livewireScripts
</body>
</html>