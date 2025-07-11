<?php

namespace App\Livewire\Admin;

use App\Models\Project;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')] // Usa el layout principal
class Dashboard extends Component
{
    public function render()
    {
        // Lógica copiada del controlador
        $userCount = User::count();
        $projectCount = Project::count();
        $completedProjects = Project::where('status', 'completed')->count();
        $overdueProjects = Project::where('status', '!=', 'completed')
            ->where('end_date', '<', Carbon::now())
            ->count();

        $statusDistribution = [
            'planning' => Project::where('status', 'planning')->count(),
            'in_progress' => Project::where('status', 'in_progress')->count(),
            'completed' => $completedProjects,
            'overdue' => $overdueProjects
        ];

        $recentActivities = Project::with('user')->latest()->take(5)->get()->map(function ($project) {
            $project->description = 'creó el proyecto ' . $project->title;
            return $project;
        });

        $recentProjects = Project::with('user')->latest()->take(5)->get();

        return view('livewire.admin.dashboard', [
            'userCount' => $userCount,
            'projectCount' => $projectCount,
            'completedProjects' => $completedProjects,
            'overdueProjects' => $overdueProjects,
            'statusDistribution' => $statusDistribution,
            'recentActivities' => $recentActivities,
            'recentProjects' => $recentProjects
        ])->title('Admin Dashboard');
    }
}