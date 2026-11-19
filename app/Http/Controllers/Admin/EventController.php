<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\City;
use App\Models\EventType;
use App\Models\Venue;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::with(['user', 'city', 'venue'])
            ->latest('starts_at')
            ->paginate(10);

        return view('admin.event.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $eventTypes = EventType::orderBy('name')->get();

        return view('admin.event.create', compact('eventTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
 public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'event_type_id' => ['nullable', 'integer', 'exists:event_types,id'],
            'venue_id' => ['nullable', 'integer', 'exists:venues,id'],
            'city_id' => ['nullable', 'integer', 'exists:cities,id'],
            'address' => ['nullable', 'string', 'max:255'],
            'starts_at' => ['required', 'date'],
            'ends_at' => ['nullable', 'date', 'after_or_equal:starts_at'],
            'cover' => ['nullable', 'image', 'max:2048'],
            'published' => ['required', 'boolean'],
        ]);

        // Generar slug único
        $validated['slug'] = Event::generateSlug($validated['title']);
        $validated['user_id'] = auth()->id();

        // Guardar portada si existe
        if ($request->hasFile('cover')) {
            $validated['cover'] = $request->file('cover')->store('events/covers', 'public');
        }

        Event::create($validated);

        return redirect()
            ->route('admin.events.index')
            ->with('status', 'Evento creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        $event->load(['user', 'eventType', 'venue.city', 'city']);

        return view('admin.event.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        $eventTypes = EventType::orderBy('name')->get();

        return view('admin.event.edit', compact('event', 'eventTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'event_type_id' => ['nullable', 'integer', 'exists:event_types,id'],
            'venue_id' => ['nullable', 'integer', 'exists:venues,id'],
            'city_id' => ['nullable', 'integer', 'exists:cities,id'],
            'address' => ['nullable', 'string', 'max:255'],
            'starts_at' => ['required', 'date'],
            'ends_at' => ['nullable', 'date', 'after_or_equal:starts_at'],
            'cover' => ['nullable', 'image', 'max:2048'],
            'published' => ['required', 'boolean'],
        ]);

        // Regenerar slug solo si el título cambió
        if ($validated['title'] !== $event->title) {
            $validated['slug'] = Event::generateSlug($validated['title'], $event->id);
        }

        // Reemplazar portada si se subió una nueva
        if ($request->hasFile('cover')) {
            // Borrar la portada anterior
            if ($event->cover) {
                Storage::disk('public')->delete($event->cover);
            }

            $validated['cover'] = $request->file('cover')->store('events/covers', 'public');
        }

        $event->update($validated);

        return redirect()
            ->route('admin.events.index')
            ->with('status', 'Evento actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        // Borrar la portada del storage si existe
        if ($event->cover) {
            Storage::disk('public')->delete($event->cover);
        }

        $event->delete();

        return redirect()
            ->route('admin.events.index')
            ->with('status', 'Evento eliminado correctamente.');
    }
}
