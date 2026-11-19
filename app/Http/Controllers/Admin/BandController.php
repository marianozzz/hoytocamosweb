<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Band;
use App\Models\EntityType;
use App\Models\Genre;
use Illuminate\Support\Facades\Storage;

class BandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bands = Band::with(['user', 'approvedBy'])
            ->latest()
            ->paginate(10);

        return view('admin.band.index', compact('bands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $entityTypes = EntityType::orderBy('name')->get();
        $genres = Genre::orderBy('name')->get();

        return view('admin.band.create', compact('entityTypes', 'genres'));
    }
    /**
     * Store a newly created resource in storage.
     */
        public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'entity_type_id' => ['nullable', 'integer', 'exists:entity_types,id'],
            'bio' => ['nullable', 'string'],
            'founded_at' => ['nullable', 'date'],
            'country_id' => ['nullable', 'integer', 'exists:countries,id'],
            'province_id' => ['nullable', 'integer', 'exists:provinces,id'],
            'city_id' => ['nullable', 'integer', 'exists:cities,id'],
            'status' => ['required', 'in:pending,approved,rejected'],
            'cover' => ['nullable', 'image', 'max:2048'],
            'gallery' => ['nullable', 'array'],
            'gallery.*' => ['image', 'max:2048'],
            'genres' => ['nullable', 'array'],
            'genres.*' => ['integer', 'exists:genres,id'],
        ]);

        // Generar slug único
        $validated['slug'] = Band::generateSlug($validated['name']);
        $validated['user_id'] = auth()->id();

        // Si se aprueba directamente, registrar aprobación
        if ($validated['status'] === 'approved') {
            $validated['approved_at'] = now();
            $validated['approved_by'] = auth()->id();
        }

        // Guardar portada
        if ($request->hasFile('cover')) {
            $validated['cover'] = $request->file('cover')->store('bands/covers', 'public');
        }

        // Guardar galería
        if ($request->hasFile('gallery')) {
            $galleryPaths = [];
            foreach ($request->file('gallery') as $image) {
                $galleryPaths[] = $image->store('bands/gallery', 'public');
            }
            $validated['gallery'] = $galleryPaths;
        }

        // Crear banda
        $band = Band::create($validated);

        // Sincronizar géneros
        $band->genres()->sync($validated['genres'] ?? []);

        // Crear los enlaces de redes sociales pendientes (desde la sesión)
        $pendingLinks = session()->pull('pending_social_links', []);

        foreach ($pendingLinks as $link) {
            $band->socialLinks()->create($link);
        }

        return redirect()
            ->route('admin.bands.index')
            ->with('status', 'Banda creada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Band $band)
    {
        $band->load([
            'user',
            'approvedBy',
            'entityType',
            'country',
            'province',
            'city',
            'genres',
            'members',
            'socialLinks.socialPlatform',
        ]);

        return view('admin.band.show', compact('band'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Band $band)
    {
        $band->load(['genres', 'country', 'province', 'city']);

        $entityTypes = EntityType::orderBy('name')->get();
        $genres = Genre::orderBy('name')->get();

        return view('admin.band.edit', compact('band', 'entityTypes', 'genres'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Band $band)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'entity_type_id' => ['nullable', 'integer', 'exists:entity_types,id'],
            'bio' => ['nullable', 'string'],
            'founded_at' => ['nullable', 'date'],
            'country_id' => ['nullable', 'integer', 'exists:countries,id'],
            'province_id' => ['nullable', 'integer', 'exists:provinces,id'],
            'city_id' => ['nullable', 'integer', 'exists:cities,id'],
            'status' => ['required', 'in:pending,approved,rejected'],
            'cover' => ['nullable', 'image', 'max:2048'],
            'gallery' => ['nullable', 'array'],
            'gallery.*' => ['image', 'max:2048'],
            'genres' => ['nullable', 'array'],
            'genres.*' => ['integer', 'exists:genres,id'],
        ]);

        // Regenerar slug solo si el nombre cambió
        if ($validated['name'] !== $band->name) {
            $validated['slug'] = Band::generateSlug($validated['name'], $band->id);
        }

        // Gestionar aprobación según estado
        if ($validated['status'] === 'approved' && $band->status !== 'approved') {
            $validated['approved_at'] = now();
            $validated['approved_by'] = auth()->id();
        } elseif ($validated['status'] !== 'approved') {
            $validated['approved_at'] = null;
            $validated['approved_by'] = null;
        }

        // Reemplazar portada si se subió una nueva
        if ($request->hasFile('cover')) {
            if ($band->cover) {
                Storage::disk('public')->delete($band->cover);
            }

            $validated['cover'] = $request->file('cover')->store('bands/covers', 'public');
        }

        // Añadir nuevas imágenes a la galería existente
        if ($request->hasFile('gallery')) {
            $currentGallery = $band->gallery ?? [];

            foreach ($request->file('gallery') as $image) {
                $currentGallery[] = $image->store('bands/gallery', 'public');
            }

            $validated['gallery'] = $currentGallery;
        }

        $band->update($validated);

        // Sincronizar géneros
        $band->genres()->sync($validated['genres'] ?? []);

        return redirect()
            ->route('admin.bands.index')
            ->with('status', 'Banda actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Band $band)
    {
        // Borrar portada del storage si existe
        if ($band->cover) {
            Storage::disk('public')->delete($band->cover);
        }

        // Borrar imágenes de la galería del storage
        if ($band->gallery) {
            foreach ($band->gallery as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $band->delete();

        return redirect()
            ->route('admin.bands.index')
            ->with('status', 'Banda eliminada correctamente.');
    }
}
