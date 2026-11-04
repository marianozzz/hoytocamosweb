<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head')
    
</head>
<body class="bg-light">

    <div class="d-flex min-vh-100">

        {{-- Sidebar --}}
        <aside class="bg-white border-end d-flex flex-column flex-shrink-0 p-3"
               style="width: 260px; min-height: 100vh;">

            {{-- Logo --}}
            <a href="{{ route('dashboard') }}" wire:navigate
               class="d-flex align-items-center mb-4 text-decoration-none text-dark">
                <x-app-logo :sidebar="true" />
            </a>

            {{-- Navegación principal --}}
            <div class="flex-grow-1">
                <p class="text-uppercase text-muted small fw-semibold mb-2 px-2">Platform</p>
                <ul class="nav nav-pills flex-column mb-4">
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" wire:navigate
                           class="nav-link d-flex align-items-center gap-2 {{ request()->routeIs('dashboard') ? 'active' : 'text-dark' }}">
                            <i class="bi bi-house"></i>
                            Dashboard
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Enlaces secundarios --}}
            <ul class="nav nav-pills flex-column mb-3">
                <li class="nav-item">
                    <a href="https://github.com/laravel/livewire-starter-kit" target="_blank"
                       class="nav-link d-flex align-items-center gap-2 text-dark">
                        <i class="bi bi-git"></i>
                        Repository
                    </a>
                </li>
                <li class="nav-item">
                    <a href="https://laravel.com/docs/starter-kits#livewire" target="_blank"
                       class="nav-link d-flex align-items-center gap-2 text-dark">
                        <i class="bi bi-book"></i>
                        Documentation
                    </a>
                </li>
            </ul>

            {{-- Menú de usuario --}}
            <div class="border-top pt-3">
                <div class="dropdown">
                    <button class="btn btn-light w-100 d-flex align-items-center gap-2 text-start"
                            type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center"
                             style="width: 32px; height: 32px; font-size: .8rem;">
                            {{ auth()->user()->initials() }}
                        </div>
                        <div class="flex-grow-1 text-truncate">
                            <div class="fw-semibold small text-truncate">{{ auth()->user()->name }}</div>
                            <div class="text-muted small text-truncate">{{ auth()->user()->email }}</div>
                        </div>
                        <i class="bi bi-chevron-down small"></i>
                    </button>
                    <ul class="dropdown-menu w-100">
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2"
                               href="{{ route('profile.edit') }}" wire:navigate>
                                <i class="bi bi-gear"></i>
                                Settings
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item d-flex align-items-center gap-2 text-danger">
                                    <i class="bi bi-box-arrow-right"></i>
                                    Log out
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </aside>

        {{-- Contenido principal --}}
        <main class="flex-grow-1 p-4">
            {{ $slot }}
        </main>

    </div>

    {{-- Toast de Livewire/Flux (si lo necesitas, o elimínalo) --}}
    @persist('toast')
        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            {{-- Aquí puedes poner tus toasts de Bootstrap --}}
        </div>
    @endpersist
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @fluxScripts
</body>
</html>