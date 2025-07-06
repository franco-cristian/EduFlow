<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Project;
use App\Models\Task;
use Livewire\Attributes\On; // <-- Importar el atributo On

class KanbanBoard extends Component
{
    public $project;
    public $todoTasks;
    public $inProgressTasks;
    public $completedTasks;

    public function mount(Project $project)
    {
        $this->project = $project;
        $this->loadTasks();
    }

    public function loadTasks()
    {
        $tasks = $this->project->tasks()->with('assignee')->get();
        $this->todoTasks = $tasks->where('status', 'todo');
        $this->inProgressTasks = $tasks->where('status', 'in_progress');
        $this->completedTasks = $tasks->where('status', 'completed');
    }

    #[On('task-updated')] // <-- Escucha el evento que enviaremos desde el frontend
    public function updateTaskStatus($taskId, $status)
    {
        $task = Task::find($taskId);
        if ($task && $task->project_id === $this->project->id) {
            $task->update(['status' => $status]);
            $this->loadTasks();
            $this->dispatch('notify', type: 'success', message: 'Estado actualizado');
        }
    }

    public function render()
    {
        return view('livewire.projects.kanban-board');
    }
}