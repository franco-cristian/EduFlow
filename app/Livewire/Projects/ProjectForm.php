<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProjectForm extends Component
{
    use WithFileUploads;

    public ?Project $project = null;

    public $projectId;
    public $title;
    public $description;
    public $status = 'planning';
    public $start_date;
    public $end_date;
    public $teacher_id;
    public $files = [];
    public $existingFiles = [];
    public $isEditing = false;

    public function mount($projectId = null)
    {
        if ($projectId) {
            $this->loadProject($projectId);
        } else {
            $this->project = new Project();
            $this->start_date = now()->format('Y-m-d');
            $this->end_date = now()->addWeek()->format('Y-m-d');
        }
    }

    public function loadProject($projectId)
    {
        $project = Project::findOrFail($projectId);
        $this->authorize('update', $project); // Autorizar antes de cargar

        $this->project = $project;
        $this->projectId = $project->id;
        $this->isEditing = true;

        $this->title = $project->title;
        $this->description = $project->description;
        $this->status = $project->status;
        $this->start_date = $project->start_date->format('Y-m-d');
        $this->end_date = $project->end_date->format('Y-m-d');
        $this->teacher_id = $project->teacher_id;
        $this->existingFiles = $project->files;
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => ['required', Rule::in(['planning', 'in_progress', 'completed'])],
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'teacher_id' => 'nullable|exists:users,id',
            'files.*' => 'nullable|file|max:10240', // 10MB
        ];
    }

    public function save()
    {
        $this->validate();

        $projectData = [
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'teacher_id' => $this->teacher_id,
        ];

        if ($this->isEditing) {
            $this->authorize('update', $this->project);
            $this->project->update($projectData);
        } else {
            $this->authorize('create', Project::class);
            $projectData['user_id'] = Auth::id();
            $this->project = Project::create($projectData);
        }

        // Guardar nuevos archivos
        if (!empty($this->files)) {
            foreach ($this->files as $file) {
                $storedName = $file->store('project_files', 'local'); // Usamos el disco 'local' explícitamente

                $this->project->files()->create([
                    'original_name' => $file->getClientOriginalName(),
                    'stored_name' => $storedName,
                    'mime_type' => $file->getMimeType(),
                    'size' => $file->getSize(),
                    'uploaded_by' => Auth::id(),
                ]);
            }
        }

        session()->flash('message', 'Proyecto guardado correctamente.');
        $this->dispatch('projectSaved');

        // Redirigir a la vista de "mostrar proyecto"
        return redirect()->route('student.projects.show', $this->project->id);
    }

    public function render()
    {
        // Cacheamos la consulta para no ejecutarla en cada render
        $teachers = User::where('role', 'teacher')->get();
        return view('livewire.project-form', compact('teachers'));
    }
}