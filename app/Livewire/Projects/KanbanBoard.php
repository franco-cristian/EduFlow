<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use App\Models\Task;
use Livewire\Component;
use Livewire\Attributes\On;

class KanbanBoard extends Component
{
    public Project $project;
    
    public $todoTasks = [];
    public $inProgressTasks = [];
    public $completedTasks = [];

    #[On('taskSaved')] 
    public function loadTasks()
    {
        $this->project = $this->project->fresh(['tasks.assignee']);
        
        $tasks = $this->project->tasks()->orderBy('id', 'desc')->get();
        
        $this->todoTasks = $tasks->where('status', 'todo')->values();
        $this->inProgressTasks = $tasks->where('status', 'in_progress')->values();
        $this->completedTasks = $tasks->where('status', 'completed')->values();
    }

    public function mount(Project $project)
    {
        $this->project = $project;
        $this->loadTasks();
    }
    
    public function updateTaskStatus($taskId, $newStatus)
    {
        $task = Task::find($taskId);

        if ($task && $task->project_id === $this->project->id) {
            $task->update(['status' => $newStatus]);
            
            // Notificamos al componente padre para que actualice el % de progreso.
            $this->dispatch('projectUpdated')->to(\App\Livewire\Student\ShowProject::class);
            
            // ***** LÍNEA CLAVE DE LA SOLUCIÓN *****
            // Le decimos al propio componente Kanban que debe recargar sus datos.
            $this->loadTasks();
        }
    }

    public function render()
    {
        return view('livewire.projects.kanban-board');
    }
}