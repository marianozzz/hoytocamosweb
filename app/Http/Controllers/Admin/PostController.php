<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with('user')
            ->latest()
            ->paginate(10);

        return view('admin.post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.post.create');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'body' => ['required', 'string'],
            'cover' => ['nullable', 'image', 'max:2048'],
            'published' => ['required', 'boolean'],
            'published_at' => ['nullable', 'date'],
        ]);

        // Generar slug único
        $validated['slug'] = Post::generateSlug($validated['title']);
        $validated['user_id'] = auth()->id();

        // Si se publica y no hay fecha, usar ahora
        if ($validated['published'] && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        // Guardar portada si existe
        if ($request->hasFile('cover')) {
            $validated['cover'] = $request->file('cover')->store('posts/covers', 'public');
        }

        Post::create($validated);

        return redirect()
            ->route('admin.posts.index')
            ->with('status', 'Post creado correctamente.');
    }
    /**
     * Display the specified resource.
     */
   public function show(Post $post)
    {
        return view('admin.post.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('admin.post.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'body' => ['required', 'string'],
            'cover' => ['nullable', 'image', 'max:2048'],
            'published' => ['required', 'boolean'],
            'published_at' => ['nullable', 'date'],
        ]);

        // Regenerar slug solo si el título cambió
        if ($validated['title'] !== $post->title) {
            $validated['slug'] = Post::generateSlug($validated['title'], $post->id);
        }

        // Si se publica y no hay fecha, usar ahora
        if ($validated['published'] && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        // Si se pasa a borrador, limpiar la fecha de publicación
        if (!$validated['published']) {
            $validated['published_at'] = null;
        }

        // Reemplazar portada si se subió una nueva
        if ($request->hasFile('cover')) {
            // Borrar la portada anterior
            if ($post->cover) {
                Storage::disk('public')->delete($post->cover);
            }

            $validated['cover'] = $request->file('cover')->store('posts/covers', 'public');
        }

        $post->update($validated);

        return redirect()
            ->route('admin.posts.index')
            ->with('status', 'Post actualizado correctamente.');
    }

        /**
         * Remove the specified resource from storage.
         */
    public function destroy(Post $post)
    {
        // Borrar la portada del storage si existe
        if ($post->cover) {
            Storage::disk('public')->delete($post->cover);
        }

        $post->delete();

        return redirect()
            ->route('admin.posts.index')
            ->with('status', 'Post eliminado correctamente.');
    }
}
