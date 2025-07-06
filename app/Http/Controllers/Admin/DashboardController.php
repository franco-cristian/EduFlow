<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProjectsExport;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{

    public function index()
    {
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

        // Simulación de actividad reciente
        $recentActivities = Project::with('user')->latest()->take(5)->get()->map(function ($project) {
            $project->description = 'creó el proyecto ' . $project->title;
            return $project;
        });

        $recentProjects = Project::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'userCount',
            'projectCount',
            'completedProjects',
            'overdueProjects',
            'statusDistribution',
            'recentActivities',
            'recentProjects'
        ));
    }

    public function exportProjects(Request $request)
    {
        return Excel::download(new ProjectsExport, 'proyectos-' . now()->format('Y-m-d') . '.xlsx');
    }

    public function generateReport(Request $request)
    {
        $projects = Project::withCount('tasks')
            ->with(['user', 'feedbacks'])
            ->filter($request->all())
            ->get();

        $pdf = Pdf::loadView('admin.reports.projects', [
            'projects' => $projects,
            'filters' => $request->all(),
        ]);

        return $pdf->download('reporte-proyectos.pdf');
    }
}
