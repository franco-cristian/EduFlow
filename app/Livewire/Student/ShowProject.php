<?php

namespace App\Livewire\Student;

use App\Models\Project;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')] // Usa el layout principal
class ShowProject extends Component
{
    public Project $project;

    public function mount(Project $project)
    {
        // Carga el proyecto con todas las relaciones que necesitaremos en la página
        $this->project = $project->load('files', 'feedbacks.user', 'tasks');
    }

    public function render()
    {
        // No necesitamos pasarle el proyecto porque ya es una propiedad pública
        return view('livewire.student.show-project')
            ->title($this->project->title); // Opcional: Pone el título del proyecto en la pestaña del navegador
    }
}