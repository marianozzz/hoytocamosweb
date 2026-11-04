{{-- Header / Navbar superior --}}
<nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top">
    <div class="container-fluid px-3">

        {{-- Botón toggle (solo móvil) --}}
        <button class="btn btn-light d-lg-none me-2" type="button"
                data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar"
                aria-controls="mobileSidebar">
            <i class="bi bi-list fs-5"></i>
        </button>

        {{-- Logo --}}
        <a class="navbar-brand d-flex align-items-center" href="{{ route('dashboard') }}" wire:navigate>
            <x-app-logo />
        </a>

        {{-- Navegación principal (solo desktop) --}}
        <ul class="navbar-nav me-auto d-none d-lg-flex">
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2 {{ request()->routeIs('dashboard') ? 'active fw-semibold' : '' }}"
                   href="{{ route('dashboard') }}" wire:navigate>
                    <i class="bi bi-grid"></i>
                    {{ __('Dashboard') }}
                </a>
            </li>
        </ul>

        {{-- Spacer --}}
        <div class="flex-grow-1"></div>

        {{-- Acciones a la derecha --}}
        <div class="d-flex align-items-center gap-1">

            {{-- Buscar --}}
            <button class="btn btn-light" type="button" title="{{ __('Search') }}">
                <i class="bi bi-search"></i>
            </button>

            {{-- Repository (solo desktop) --}}
            <a href="https://github.com/laravel/livewire-starter-kit" target="_blank"
               class="btn btn-light d-none d-lg-inline-flex" title="{{ __('Repository') }}">
                <i class="bi bi-git"></i>
            </a>

            {{-- Documentation (solo desktop) --}}
            <a href="https://laravel.com/docs/starter-kits#livewire" target="_blank"
               class="btn btn-light d-none d-lg-inline-flex" title="{{ __('Documentation') }}">
                <i class="bi bi-book"></i>
            </a>

            {{-- Menú de usuario --}}
            <div class="dropdown ms-2">
                <button class="btn btn-light d-flex align-items-center gap-2" type="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center"
                         style="width: 32px; height: 32px; font-size: .8rem;">
                        {{ auth()->user()->initials() }}
                    </div>
                    <i class="bi bi-chevron-down small d-none d-lg-inline"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li class="px-3 py-2">
                        <div class="fw-semibold small">{{ auth()->user()->name }}</div>
                        <div class="text-muted small">{{ auth()->user()->email }}</div>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center gap-2"
                           href="{{ route('profile.edit') }}" wire:navigate>
                            <i class="bi bi-gear"></i>
                            {{ __('Settings') }}
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item d-flex align-items-center gap-2 text-danger">
                                <i class="bi bi-box-arrow-right"></i>
                                {{ __('Log out') }}
                            </button>
                        </form>
                    </li>
                </ul>
            </div>

        </div>
    </div>
</nav>

{{-- Offcanvas: menú lateral para móvil --}}
<div class="offcanvas offcanvas-start" tabindex="-1" id="mobileSidebar" aria-labelledby="mobileSidebarLabel">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title" id="mobileSidebarLabel">
            <x-app-logo :sidebar="true" />
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body d-flex flex-column p-3">

        <p class="text-uppercase text-muted small fw-semibold mb-2 px-2">{{ __('Platform') }}</p>
        <ul class="nav nav-pills flex-column mb-4">
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" wire:navigate
                   class="nav-link d-flex align-items-center gap-2 {{ request()->routeIs('dashboard') ? 'active' : 'text-dark' }}">
                    <i class="bi bi-grid"></i>
                    {{ __('Dashboard') }}
                </a>
            </li>
        </ul>

        <div class="flex-grow-1"></div>

        <ul class="nav nav-pills flex-column">
            <li class="nav-item">
                <a href="https://github.com/laravel/livewire-starter-kit" target="_blank"
                   class="nav-link d-flex align-items-center gap-2 text-dark">
                    <i class="bi bi-git"></i>
                    {{ __('Repository') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="https://laravel.com/docs/starter-kits#livewire" target="_blank"
                   class="nav-link d-flex align-items-center gap-2 text-dark">
                    <i class="bi bi-book"></i>
                    {{ __('Documentation') }}
                </a>
            </li>
        </ul>
    </div>
</div>