<?php

use App\Models\City;
use App\Models\Venue;
use Livewire\Component;

new class extends Component
{
    public $venues = [];
    public $cities = [];

    public $venue_id = null;
    public $address = '';
    public $city_id = null;

    public function mount($venueId = null, $address = null, $cityId = null)
    {
        $this->venue_id = $venueId;
        $this->address = $address ?? '';
        $this->city_id = $cityId;

        $this->venues = Venue::with('city')->orderBy('name')->get();
        $this->cities = City::orderBy('name')->get();
    }

    public function updatedVenueId($value)
    {
        if (!$value) {
            return;
        }

        $venue = Venue::find($value);

        if ($venue) {
            $this->address = $venue->address ?? '';
            $this->city_id = $venue->city_id;
        }
    }
};
?>

<div>
    {{-- Select de venue --}}
    <div class="mb-3">
        <label for="venue_id" class="form-label fw-semibold">Lugar</label>
        <select id="venue_id" name="venue_id" wire:model.live="venue_id"
                class="form-select">
            <option value="">Sin definir</option>
            @foreach ($venues as $venue)
                <option value="{{ $venue->id }}">{{ $venue->name }}</option>
            @endforeach
        </select>
    </div>

    {{-- Dirección --}}
    <div class="mb-3">
        <label for="address" class="form-label fw-semibold">Dirección</label>
        <input type="text" id="address" name="address" wire:model="address"
               class="form-control" placeholder="Calle y número">
    </div>

    {{-- Ciudad --}}
    <div class="mb-0">
        <label for="city_id" class="form-label fw-semibold">Ciudad</label>
        <select id="city_id" name="city_id" wire:model="city_id" class="form-select">
            <option value="">Sin definir</option>
            @foreach ($cities as $city)
                <option value="{{ $city->id }}">{{ $city->name }}</option>
            @endforeach
        </select>
    </div>

    {{-- Inputs ocultos para el formulario padre --}}
    <input type="hidden" name="venue_id" value="{{ $venue_id }}">
    <input type="hidden" name="address" value="{{ $address }}">
    <input type="hidden" name="city_id" value="{{ $city_id }}">
</div>