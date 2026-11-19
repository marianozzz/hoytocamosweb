<?php

use App\Models\SocialLink;
use App\Models\SocialPlatform;
use Livewire\Component;

new class extends Component
{
    public $linkableId;
    public $linkableType;

    public $platforms = [];
    public $links = [];

    public $newPlatformId = null;
    public $newUrl = '';

    public function mount($linkableId = null, $linkableType = null)
    {
        $this->linkableId = $linkableId;
        $this->linkableType = $linkableType;

        $this->platforms = SocialPlatform::where('active', true)->orderBy('name')->get();

        if ($this->linkableId && $this->linkableType) {
            $this->loadLinks();
        }
    }

    public function loadLinks()
    {
        $this->links = SocialLink::with('socialPlatform')
            ->where('linkable_id', $this->linkableId)
            ->where('linkable_type', $this->linkableType)
            ->get()
            ->map(fn ($link) => [
                'id' => $link->id,
                'platform_id' => $link->social_platform_id,
                'platform_name' => $link->socialPlatform->name,
                'platform_icon' => $link->socialPlatform->icon,
                'url' => $link->url,
            ])
            ->toArray();
    }

    public function addLink()
    {
        $this->validate([
            'newPlatformId' => ['required', 'integer', 'exists:social_platforms,id'],
            'newUrl' => ['required', 'string', 'max:255'],
        ], [
            'newPlatformId.required' => 'Selecciona una plataforma.',
            'newUrl.required' => 'Escribe la URL.',
        ]);

        if (!$this->linkableId) {
            // Creación: guardar en sesión para procesar después de crear el modelo
            session()->push('pending_social_links', [
                'social_platform_id' => $this->newPlatformId,
                'url' => $this->newUrl,
            ]);

            // Mostrar en la lista local
            $platform = SocialPlatform::find($this->newPlatformId);
            $this->links[] = [
                'id' => null,
                'platform_id' => $platform->id,
                'platform_name' => $platform->name,
                'platform_icon' => $platform->icon,
                'url' => $this->newUrl,
            ];
        } else {
            SocialLink::create([
                'linkable_id' => $this->linkableId,
                'linkable_type' => $this->linkableType,
                'social_platform_id' => $this->newPlatformId,
                'url' => $this->newUrl,
            ]);

            $this->loadLinks();
        }

        $this->newPlatformId = null;
        $this->newUrl = '';
    }

    public function removeLink($index)
    {
        $link = $this->links[$index] ?? null;

        if (!$link) {
            return;
        }

        if (!empty($link['id'])) {
            SocialLink::find($link['id'])?->delete();
        } else {
            // Si es un enlace pendiente (sin ID), quitarlo también de la sesión
            $pending = session()->get('pending_social_links', []);

            $pending = array_values(array_filter($pending, function ($item) use ($link) {
                return !($item['social_platform_id'] == $link['platform_id'] && $item['url'] === $link['url']);
            }));

            session()->put('pending_social_links', $pending);
        }

        unset($this->links[$index]);
        $this->links = array_values($this->links);
    }
};
?>

<div>
    <h6 class="fw-bold mb-3">
        <i class="bi bi-share me-1" style="color: var(--ht-magenta);"></i>
        Redes sociales
    </h6>

    {{-- Lista de enlaces existentes --}}
    @if (count($links) > 0)
        <div class="mb-3">
            @foreach ($links as $index => $link)
                <div class="d-flex align-items-center gap-2 mb-2 p-2 border rounded-3">
                    <i class="bi {{ $link['platform_icon'] ?? 'bi-share' }} fs-5"></i>
                    <div class="flex-grow-1 text-truncate">
                        <div class="fw-semibold small">{{ $link['platform_name'] }}</div>
                        <div class="text-muted small text-truncate">{{ $link['url'] }}</div>
                    </div>
                    <button type="button" wire:click="removeLink({{ $index }})"
                            class="btn btn-sm btn-outline-danger rounded-circle"
                            title="Eliminar">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-muted small mb-3">No hay redes sociales añadidas.</p>
    @endif

    {{-- Formulario para añadir --}}
    <hr class="my-3">
    <p class="text-muted small mb-2">Añadir red social:</p>

    <div class="row g-2">
        <div class="col-5">
            <select wire:model="newPlatformId" class="form-select form-select-sm">
                <option value="">Plataforma</option>
                @foreach ($platforms as $platform)
                    <option value="{{ $platform->id }}">{{ $platform->name }}</option>
                @endforeach
            </select>
            @error('newPlatformId')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-5">
            <input type="url" wire:model="newUrl" class="form-control form-control-sm"
                   placeholder="https://...">
            @error('newUrl')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-2">
            <button type="button" wire:click="addLink" class="btn btn-sm btn-dark w-100">
                <i class="bi bi-plus-lg"></i>
            </button>
        </div>
    </div>
</div>