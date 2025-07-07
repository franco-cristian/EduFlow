<?php

namespace App\Livewire\Student;

use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ProjectList extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';

    // Método para eliminar un proyecto
    public function deleteProject($projectId)
    {
        $project = Project::findOrFail($projectId);
        
        // Usamos la policy para asegurarnos de que el usuario puede eliminarlo
        $this->authorize('delete', $project);

        $project->delete();

        // Opcional: Notificación al usuario
        session()->flash('message', 'Proyecto eliminado correctamente.');
    }

    // El método de editar simplemente redirige a la página de edición
    public function editProject($projectId)
    {
        return redirect()->route('student.projects.edit', $projectId);
    }

    public function render()
    {
        $projects = Project::where('user_id', Auth::id())
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%');
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->latest()
            ->paginate(10);

        return view('livewire.student.project-list', [
            'projects' => $projects
        ]);
    }
}