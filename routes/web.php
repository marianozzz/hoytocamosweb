<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\PublicPostController;

// Portada pública
Route::get('/', function () {
    $posts = \App\Models\Post::where('published', true)
        ->whereNotNull('published_at')
        ->where('published_at', '<=', now())
        ->latest('published_at')
        ->take(2)
        ->get();

    return view('welcome', compact('posts'));
})->name('home');


// Blog público
Route::get('/noticias', [PublicPostController::class, 'index'])->name('posts.index');
Route::get('/noticias/{slug}', [PublicPostController::class, 'show'])->name('posts.show');

// Rutas de usuario autenticado
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');

    // Mi perfil
    Route::get('/perfil', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/perfil/editar', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/perfil', [ProfileController::class, 'update'])->name('profile.update');

    Route::resource('users', UserController::class);
});

// Login del panel de administración (público, sin middleware)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.attempt');
});

// Panel de administración (protegido por admin)
Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');

      // CRUD de posts (blog)
    Route::resource('posts', \App\Http\Controllers\Admin\PostController::class);

    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
});

require __DIR__.'/settings.php';