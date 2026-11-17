<?php

use App\Models\City;
use App\Models\Country;
use App\Models\Province;
use Livewire\Component;

new class extends Component
{
    public $countries = [];
    public $provinces = [];
    public $cities = [];

    public $country_id = null;
    public $province_id = null;
    public $city_id = null;

    public function mount($countryId = null, $provinceId = null, $cityId = null)
    {
        $this->country_id = $countryId;
        $this->province_id = $provinceId;
        $this->city_id = $cityId;

        $this->countries = Country::orderBy('name')->get();

        if ($this->country_id) {
            $this->provinces = Province::where('country_id', $this->country_id)->orderBy('name')->get();
        }

        if ($this->province_id) {
            $this->cities = City::where('province_id', $this->province_id)->orderBy('name')->get();
        }
    }

    public function updatedCountryId($value)
    {
        $this->provinces = $value
            ? Province::where('country_id', $value)->orderBy('name')->get()
            : [];
        $this->province_id = null;
        $this->city_id = null;
        $this->cities = [];
    }

    public function updatedProvinceId($value)
    {
        $this->cities = $value
            ? City::where('province_id', $value)->orderBy('name')->get()
            : [];
        $this->city_id = null;
    }
};
?>

<div>
    <div class="row g-3">
        {{-- País --}}
        <div class="col-md-4">
            <label for="country_id" class="form-label fw-semibold">País</label>
            <select id="country_id" name="country_id" wire:model.live="country_id"
                    class="form-select @error('country_id') is-invalid @enderror">
                <option value="">Sin definir</option>
                @foreach ($countries as $country)
                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                @endforeach
            </select>
            @error('country_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Provincia --}}
        <div class="col-md-4">
            <label for="province_id" class="form-label fw-semibold">Provincia</label>
            <select id="province_id" name="province_id" wire:model.live="province_id"
                    class="form-select @error('province_id') is-invalid @enderror"
                    @if (empty($provinces)) disabled @endif>
                <option value="">Sin definir</option>
                @foreach ($provinces as $province)
                    <option value="{{ $province->id }}">{{ $province->name }}</option>
                @endforeach
            </select>
            @error('province_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Ciudad --}}
        <div class="col-md-4">
            <label for="city_id" class="form-label fw-semibold">Ciudad</label>
            <select id="city_id" name="city_id" wire:model.live="city_id"
                    class="form-select @error('city_id') is-invalid @enderror"
                    @if (empty($cities)) disabled @endif>
                <option value="">Sin definir</option>
                @foreach ($cities as $city)
                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                @endforeach
            </select>
            @error('city_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    {{-- Inputs ocultos para el formulario padre --}}
    <input type="hidden" name="country_id" value="{{ $country_id }}">
    <input type="hidden" name="province_id" value="{{ $province_id }}">
    <input type="hidden" name="city_id" value="{{ $city_id }}">
</div>