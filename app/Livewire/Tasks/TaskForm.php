<?php

namespace App\Livewire\Tasks;

use Livewire\Component;
use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class TaskForm extends Component
{
    public $projectId;
    public $taskId;
    public $title;
    public $description;
    public $status = 'todo';
    public $due_date;
    public $assigned_to;
    public $isEditing = false;

    protected $listeners = ['editTask' => 'loadTask'];

    public function mount($projectId, $taskId = null)
    {
        $this->projectId = $projectId;
        
        if ($taskId) {
            $this->loadTask($taskId);
        } else {
            $this->due_date = now()->addDays(3)->format('Y-m-d');
        }
    }

    public function loadTask($taskId)
    {
        $this->taskId = $taskId;
        $task = Task::findOrFail($taskId);
        
        $this->isEditing = true;
        $this->title = $task->title;
        $this->description = $task->description;
        $this->status = $task->status;
        $this->due_date = $task->due_date->format('Y-m-d');
        $this->assigned_to = $task->assigned_to;
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => ['required', Rule::in(['todo', 'in_progress', 'completed'])],
            'due_date' => 'required|date',
            'assigned_to' => 'required|exists:users,id',
        ];
    }

    public function save()
    {
        $this->validate();

        $taskData = [
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'due_date' => $this->due_date,
            'assigned_to' => $this->assigned_to,
            'project_id' => $this->projectId,
        ];

        if ($this->isEditing) {
            $task = Task::findOrFail($this->taskId);
            $task->update($taskData);
        } else {
            Task::create($taskData);
        }

        session()->flash('message', 'Tarea guardada correctamente');
        $this->dispatch('taskSaved');
    }

    public function render()
    {
        $project = Project::findOrFail($this->projectId);
        $students = $project->students;
        
        return view('livewire.task-form', compact('students'));
    }
}