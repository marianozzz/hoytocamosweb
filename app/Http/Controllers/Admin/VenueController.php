<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Venue;
use App\Models\City;
use Illuminate\Support\Facades\Storage;

class VenueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $venues = Venue::with('city')
            ->orderBy('name')
            ->paginate(10);

        return view('admin.venue.index', compact('venues'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cities = City::orderBy('name')->get();

        return view('admin.venue.create', compact('cities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'address' => ['nullable', 'string', 'max:255'],
            'country_id' => ['nullable', 'integer', 'exists:countries,id'],
            'province_id' => ['nullable', 'integer', 'exists:provinces,id'],
            'city_id' => ['nullable', 'integer', 'exists:cities,id'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'cover' => ['nullable', 'image', 'max:2048'],
            'gallery' => ['nullable', 'array'],
            'gallery.*' => ['image', 'max:2048'],
        ]);

        // Generar slug único
        $validated['slug'] = Venue::generateSlug($validated['name']);

        // Guardar portada si existe
        if ($request->hasFile('cover')) {
            $validated['cover'] = $request->file('cover')->store('venues/covers', 'public');
        }

        // Guardar galería si existe
        if ($request->hasFile('gallery')) {
            $galleryPaths = [];
            foreach ($request->file('gallery') as $image) {
                $galleryPaths[] = $image->store('venues/gallery', 'public');
            }
            $validated['gallery'] = $galleryPaths;
        }

        Venue::create($validated);

        return redirect()
            ->route('admin.venues.index')
            ->with('status', 'Lugar creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
   public function show(Venue $venue)
    {
        $venue->load('city.province.country');

        return view('admin.venue.show', compact('venue'));
    }

    /**
     * Show the form for editing the specified resource.
     */
  public function edit(Venue $venue)
    {
        return view('admin.venue.edit', compact('venue'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Venue $venue)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'address' => ['nullable', 'string', 'max:255'],
            'country_id' => ['nullable', 'integer', 'exists:countries,id'],
            'province_id' => ['nullable', 'integer', 'exists:provinces,id'],
            'city_id' => ['nullable', 'integer', 'exists:cities,id'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'cover' => ['nullable', 'image', 'max:2048'],
            'gallery' => ['nullable', 'array'],
            'gallery.*' => ['image', 'max:2048'],
        ]);

        // Regenerar slug solo si el nombre cambió
        if ($validated['name'] !== $venue->name) {
            $validated['slug'] = Venue::generateSlug($validated['name'], $venue->id);
        }

        // Reemplazar portada si se subió una nueva
        if ($request->hasFile('cover')) {
            if ($venue->cover) {
                Storage::disk('public')->delete($venue->cover);
            }

            $validated['cover'] = $request->file('cover')->store('venues/covers', 'public');
        }

        // Añadir nuevas imágenes a la galería existente
        if ($request->hasFile('gallery')) {
            $currentGallery = $venue->gallery ?? [];

            foreach ($request->file('gallery') as $image) {
                $currentGallery[] = $image->store('venues/gallery', 'public');
            }

            $validated['gallery'] = $currentGallery;
        }

        $venue->update($validated);

        return redirect()
            ->route('admin.venues.index')
            ->with('status', 'Lugar actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Venue $venue)
    {
        // Borrar portada del storage si existe
        if ($venue->cover) {
            Storage::disk('public')->delete($venue->cover);
        }

        // Borrar imágenes de la galería del storage
        if ($venue->gallery) {
            foreach ($venue->gallery as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $venue->delete();

        return redirect()
            ->route('admin.venues.index')
            ->with('status', 'Lugar eliminado correctamente.');
    }
}
