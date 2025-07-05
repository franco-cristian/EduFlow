<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class StatsDashboard extends Component
{
    public $timeRange = 'month'; // month, quarter, year

public function render()
{
    $user = Auth::user();

    $projects = Project::query()
        ->when($user->role === 'student', fn($q) => $q->where('user_id', $user->id))
        ->when($user->role === 'teacher', fn($q) => $q->where('teacher_id', $user->id))
        ->get();

    $projectStatusData = [
        'labels' => ['Planificación', 'En Progreso', 'Completados'],
        'series' => [
            $projects->where('status', 'planning')->count(),
            $projects->where('status', 'in_progress')->count(),
            $projects->where('status', 'completed')->count(),
        ],
    ];

    $tasks = Task::whereIn('project_id', $projects->pluck('id'))->get();

    $taskStatusData = [
        'labels' => ['Por Hacer', 'En Progreso', 'Completadas'],
        'series' => [
            $tasks->where('status', 'todo')->count(),
            $tasks->where('status', 'in_progress')->count(),
            $tasks->where('status', 'completed')->count(),
        ],
    ];

    $progressLabels = [];
    $progressSeries = [];

    for ($i = 5; $i >= 0; $i--) {
        $date = now()->subMonths($i);
        $progressLabels[] = $date->format('M Y');
        $progressSeries[] = Project::whereMonth('end_date', $date->month)
            ->whereYear('end_date', $date->year)
            ->where('status', 'completed')
            ->count();
    }

    $progressData = [
        'labels' => $progressLabels,
        'series' => $progressSeries,
    ];

    return view('livewire.stats-dashboard', compact(
        'projectStatusData',
        'taskStatusData',
        'progressData'
    ));
}

}