<?php

namespace App\Livewire\Teacher;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Dashboard extends Component
{
    use WithPagination;

    public function render()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Obtenemos los proyectos donde este usuario es el supervisor
        $supervisedProjects = $user->supervisedProjects()->with('user')->paginate(10);

        // Estadísticas para el profesor
        $totalSupervised = $user->supervisedProjects()->count();
        $completedSupervised = $user->supervisedProjects()->where('status', 'completed')->count();
        $inProgressSupervised = $user->supervisedProjects()->where('status', 'in_progress')->count();

        return view('livewire.teacher.dashboard', [
            'projects' => $supervisedProjects,
            'totalSupervised' => $totalSupervised,
            'completedSupervised' => $completedSupervised,
            'inProgressSupervised' => $inProgressSupervised
        ])->title('Teacher Dashboard');
    }
}