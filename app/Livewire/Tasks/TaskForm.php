<?php

namespace App\Livewire\Tasks;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;

class TaskForm extends Component
{
    public Project $project;
    public ?Task $task = null;

    public $title;
    public $description;
    public $status = 'todo';
    public $due_date;
    public $assigned_to;

    public $isEditing = false;
    public $showModal = false;

    protected $listeners = ['editTask' => 'edit'];

    public function mount(Project $project)
    {
        $this->project = $project;
        $this->task = new Task();
        $this->due_date = now()->addDays(7)->format('Y-m-d');
        $this->assigned_to = Auth::id(); // Por defecto, se asigna al usuario actual
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => ['required', Rule::in(['todo', 'in_progress', 'completed'])],
            'due_date' => 'required|date',
            'assigned_to' => 'nullable|exists:users,id',
        ];
    }
    
    public function openModal()
    {
        $this->resetErrorBag();
        $this->isEditing = false;
        $this->task = new Task();
        $this->title = '';
        $this->description = '';
        $this->status = 'todo';
        $this->due_date = now()->addDays(7)->format('Y-m-d');
        $this->assigned_to = Auth::id();
        $this->showModal = true;
    }

    public function edit(Task $task)
    {
        $this->resetErrorBag();
        $this->isEditing = true;
        $this->task = $task;
        $this->title = $task->title;
        $this->description = $task->description;
        $this->status = $task->status;
        $this->due_date = $task->due_date->format('Y-m-d');
        $this->assigned_to = $task->assigned_to;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        $this->task->fill([
            'project_id' => $this->project->id,
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'due_date' => $this->due_date,
            'assigned_to' => $this->assigned_to ?? Auth::id(), // Asigna al creador si no se elige a nadie
        ]);
        
        $this->task->save();

        $this->showModal = false;
        $this->dispatch('taskSaved'); // Notifica al Kanban que debe refrescarse
        session()->flash('message', 'Tarea guardada correctamente.');
    }

    public function render()
    {
        // En el futuro, aquí podrías pasar una lista de miembros del equipo.
        $teamMembers = User::where('id', Auth::id())->get();

        return view('livewire.tasks.task-form', [
            'teamMembers' => $teamMembers
        ]);
    }
}