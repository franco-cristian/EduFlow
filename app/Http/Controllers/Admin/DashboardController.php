<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProjectsExport;

class DashboardController extends Controller
{
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
