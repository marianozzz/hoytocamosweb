<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Si no está autenticado, redirigir al login de admin
        if (!auth()->check()) {
            return redirect()->route('admin.login');
        }

        // Si está autenticado pero no es admin, 403
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'No tienes permiso para acceder al panel de administración.');
        }

        return $next($request);
    }
}
