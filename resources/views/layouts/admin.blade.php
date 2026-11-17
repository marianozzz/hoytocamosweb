<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Panel de Administración')</title>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-light">
    <div class="d-flex min-vh-100">

        {{-- Sidebar --}}
        <aside class="bg-dark text-white p-3 d-flex flex-column flex-shrink-0" style="width: 260px;">
            <a href="{{ route('admin.dashboard') }}" class="text-white text-decoration-none mb-4">
                <h5 class="fw-bold mb-0">
                    <i class="bi bi-music-note-beamed me-2" style="color: var(--ht-magenta);"></i>
                    HoyTocamos Admin
                </h5>
            </a>

            <ul class="nav nav-pills flex-column mb-auto gap-1">
                {{-- Dashboard --}}
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                       class="nav-link text-white d-flex align-items-center {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2 me-2"></i> Dashboard
                    </a>
                </li>

                {{-- Usuarios --}}
                <li class="nav-item">
                    <a href="#"
                       class="nav-link text-white d-flex align-items-center {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <i class="bi bi-people me-2"></i> Usuarios
                    </a>
                </li>

                {{-- Blog --}}
                <li class="nav-item">
                    <a href="{{ route('admin.posts.index') }}"
                       class="nav-link text-white d-flex align-items-center {{ request()->routeIs('admin.posts.*') ? 'active' : '' }}">
                        <i class="bi bi-journal-text me-2"></i> Blog
                    </a>
                </li>

                {{-- Calendario --}}
                <li class="nav-item">
                    <a href="#"
                       class="nav-link text-white d-flex align-items-center {{ request()->routeIs('admin.calendar.*') ? 'active' : '' }}">
                        <i class="bi bi-calendar-event me-2"></i> Calendario
                    </a>
                </li>
            </ul>

            <hr class="text-white-50">

            @auth
                {{-- Usuario logueado --}}
                <div class="d-flex align-items-center gap-2 mb-2 px-2">
                    <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center"
                         style="width: 32px; height: 32px; font-size: .75rem;">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="small text-truncate">
                        <div class="fw-semibold">{{ auth()->user()->name }}</div>
                        <div class="text-white-50 text-truncate">{{ auth()->user()->email }}</div>
                    </div>
                </div>

                {{-- Logout --}}
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm w-100">
                        <i class="bi bi-box-arrow-right me-1"></i> Cerrar sesión
                    </button>
                </form>
            @else
                {{-- Invitado: enlace al login de admin --}}
                <a href="{{ route('admin.login') }}" class="btn btn-outline-light btn-sm w-100">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Iniciar sesión
                </a>
            @endauth

            <a href="{{ route('home') }}" class="btn btn-link btn-sm text-white-50 mt-2 text-decoration-none">
                <i class="bi bi-arrow-left me-1"></i> Volver al sitio
            </a>
        </aside>

        {{-- Contenido --}}
        <main class="flex-grow-1 p-4 overflow-auto">
            @yield('content')
        </main>

    </div>
</body>
</html>