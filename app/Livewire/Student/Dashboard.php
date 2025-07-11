<?php

namespace App\Livewire\Student;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')] // <-- Usa el layout principal
class Dashboard extends Component
{
    public function render()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $projects = $user->projects()->latest()->paginate(5);
        $activeProjects = $user->projects()->whereIn('status', ['planning', 'in_progress'])->count();
        $completedProjects = $user->projects()->where('status', 'completed')->count();
        $pendingTasks = $user->tasks()->where('status', '!=', 'completed')->count();

        return view('livewire.student.dashboard', [
            'projects' => $projects, 
            'activeProjects' => $activeProjects, 
            'completedProjects' => $completedProjects, 
            'pendingTasks' => $pendingTasks
        ])->title('Dashboard'); // <-- Opcional: define el título de la página
    }
}