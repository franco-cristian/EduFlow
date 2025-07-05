<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class HomeController extends Controller
{
    /**
     * Redirige al usuario a su dashboard correspondiente según su rol.
     */
    public function index(): RedirectResponse
    {
        $user = Auth::user();

        $route = match ($user->role) {
            'admin' => 'admin.dashboard',
            'teacher' => 'teacher.dashboard',
            'student' => 'student.dashboard',
            default => 'login',
        };

        return redirect()->route($route);
    }
}