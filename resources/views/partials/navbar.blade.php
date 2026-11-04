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
                    <a class="nav-link" href="#noticias">Noticias</a>
                </li>
            </ul>

            <div class="d-flex gap-2 align-items-center">
                @auth
                    {{-- Dropdown de usuario --}}
                    <div class="dropdown">
                        <button class="btn btn-ht-primary btn-sm dropdown-toggle d-flex align-items-center gap-2"
                                type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="rounded-circle d-inline-flex align-items-center justify-content-center"
                                  style="width: 24px; height: 24px; background: rgba(255,255,255,.2); font-size: .75rem;">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </span>
                            <span class="d-none d-lg-inline">{{ auth()->user()->name }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li class="px-3 py-2">
                                <div class="fw-semibold small">{{ auth()->user()->name }}</div>
                                <div class="text-muted small">{{ auth()->user()->email }}</div>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center gap-2"
                                   href="{{ route('dashboard') }}">
                                    <i class="bi bi-grid"></i>
                                    Mi panel
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item d-flex align-items-center gap-2 text-danger">
                                        <i class="bi bi-box-arrow-right"></i>
                                        Cerrar sesión
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
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