<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\Genre;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class ProfileController extends Controller
{
    /**
     * Muestra el perfil del usuario autenticado.
     */
    public function index()
    {
        $user = auth()->user()->load(['genres', 'country', 'province', 'city']);

        return view('users.profile.index', compact('user'));
    }

    /**
     * Muestra el formulario de edición del perfil.
     */
    public function edit()
    {
        $user = auth()->user()->load(['genres', 'country', 'province', 'city']);
        $allGenres = Genre::orderBy('name')->get();
        $countries = Country::orderBy('name')->get();
        $provinces = $user->country_id
            ? Province::where('country_id', $user->country_id)->orderBy('name')->get()
            : collect();
        $cities = $user->province_id
            ? City::where('province_id', $user->province_id)->orderBy('name')->get()
            : collect();

        return view('users.profile.edit', compact('user', 'allGenres', 'countries', 'provinces', 'cities'));
    }

    /**
     * Actualiza los datos del perfil, el avatar, la ubicación y los géneros musicales.
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'avatar' => ['nullable', File::image()->max('2mb')],
            'country_id' => ['nullable', 'integer', 'exists:countries,id'],
            'province_id' => ['nullable', 'integer', 'exists:provinces,id'],
            'city_id' => ['nullable', 'integer', 'exists:cities,id'],
            'genres' => ['nullable', 'array'],
            'genres.*' => ['integer', 'exists:genres,id'],
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'country_id' => $validated['country_id'] ?? null,
            'province_id' => $validated['province_id'] ?? null,
            'city_id' => $validated['city_id'] ?? null,
        ]);

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            $path = $request->file('avatar')->store('avatars', 'public');
            $user->update(['avatar' => $path]);
        }

        $user->genres()->sync($validated['genres'] ?? []);

        return redirect()
            ->route('profile.index')
            ->with('status', 'Perfil actualizado correctamente.');
    }
}