<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'teacher':
                // En el futuro, redirigir al dashboard de profesor
                // return redirect()->route('teacher.dashboard');
                // Por ahora, lo mandamos a una vista genérica o a la raíz
                return redirect()->route('welcome'); 
            case 'student':
            default:
                return redirect()->route('student.dashboard');
        }
    }
}