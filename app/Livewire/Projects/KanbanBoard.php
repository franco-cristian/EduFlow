<?php

namespace App\Livewire\Projects;

use Livewire\Component;
use App\Models\Project;
use App\Models\Task;

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
        $this->todoTasks = $this->project->tasks()->where('status', 'todo')->get();
        $this->inProgressTasks = $this->project->tasks()->where('status', 'in_progress')->get();
        $this->completedTasks = $this->project->tasks()->where('status', 'completed')->get();
    }

    public function updateTaskStatus($taskId, $status)
    {
        Task::find($taskId)->update(['status' => $status]);
        $this->loadTasks();
        $this->dispatch('notify', type: 'success', message: 'Estado actualizado');
    }

    public function render()
    {
        return view('livewire.kanban-board');
    }
}