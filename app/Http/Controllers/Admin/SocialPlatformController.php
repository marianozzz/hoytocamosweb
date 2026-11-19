<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SocialPlatform;

class SocialPlatformController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $platforms = SocialPlatform::orderBy('name')->paginate(15);

        return view('admin.social-platform.index', compact('platforms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.social-platform.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:social_platforms,name'],
            'icon' => ['nullable', 'string', 'max:255'],
            'base_url' => ['nullable', 'string', 'max:255'],
            'active' => ['required', 'boolean'],
        ]);

        // Generar slug único
        $validated['slug'] = SocialPlatform::generateSlug($validated['name']);

        SocialPlatform::create($validated);

        return redirect()
            ->route('admin.social-platforms.index')
            ->with('status', 'Plataforma creada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SocialPlatform $socialPlatform)
    {
        return view('admin.social-platform.edit', compact('socialPlatform'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SocialPlatform $socialPlatform)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:social_platforms,name,' . $socialPlatform->id],
            'icon' => ['nullable', 'string', 'max:255'],
            'base_url' => ['nullable', 'string', 'max:255'],
            'active' => ['required', 'boolean'],
        ]);

        // Regenerar slug solo si el nombre cambió
        if ($validated['name'] !== $socialPlatform->name) {
            $validated['slug'] = SocialPlatform::generateSlug($validated['name'], $socialPlatform->id);
        }

        $socialPlatform->update($validated);

        return redirect()
            ->route('admin.social-platforms.index')
            ->with('status', 'Plataforma actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SocialPlatform $socialPlatform)
    {
        $socialPlatform->delete();

        return redirect()
            ->route('admin.social-platforms.index')
            ->with('status', 'Plataforma eliminada correctamente.');
    }
}
