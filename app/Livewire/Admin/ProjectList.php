<?php

namespace App\Livewire\Admin;

use App\Models\Project;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class ProjectList extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        $projects = Project::with('user', 'teacher')
            ->where('title', 'like', '%'.$this->search.'%')
            ->latest()
            ->paginate(15);

        return view('livewire.admin.project-list', [
            'projects' => $projects,
        ])->title('Todos los Proyectos');
    }
}
