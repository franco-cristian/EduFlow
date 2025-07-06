<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */ // <-- PISTA PARA INTELEPHENSE
        $user = Auth::user();

        // Ahora el linter sabe que $user tiene los métodos projects() y tasks()
        $projects = $user->projects()->latest()->paginate(5);

        $activeProjects = $user->projects()->whereIn('status', ['planning', 'in_progress'])->count();
        $completedProjects = $user->projects()->where('status', 'completed')->count();
        $pendingTasks = $user->tasks()->where('status', '!=', 'completed')->count();

        return view('student.dashboard', compact(
            'projects', 
            'activeProjects', 
            'completedProjects', 
            'pendingTasks'
        ));
    }
}