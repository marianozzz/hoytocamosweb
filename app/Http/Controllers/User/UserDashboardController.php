<?php


namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    /**
     * Muestra el dashboard del usuario autenticado.
     */
    public function index()
    {
        return view('users.dashboard');
    }
}