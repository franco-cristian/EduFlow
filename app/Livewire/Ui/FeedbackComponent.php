<?php

namespace App\Livewire\Ui;

use App\Models\Feedback;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FeedbackComponent extends Component
{
    public Project $project;
    public $content = '';
    
    // El método mount es más eficiente para pasar modelos completos
    public function mount(Project $project)
    {
        $this->project = $project;
    }

    public function rules()
    {
        return [
            'content' => 'required|string|min:5|max:1000',
        ];
    }

    public function addFeedback()
    {
        $this->validate();

        Feedback::create([
            'project_id' => $this->project->id,
            'user_id' => Auth::id(),
            'content' => $this->content,
        ]);

        $this->reset('content'); // Limpia el textarea
        session()->flash('feedback_message', 'Comentario añadido.');
    }

    public function render()
    {
        // Cargamos los feedbacks con sus relaciones (usuario) para optimizar consultas
        $feedbacks = $this->project->feedbacks()->with('user')->latest()->get();
        
        return view('livewire.ui.feedback-component', [
            'feedbacks' => $feedbacks
        ]);
    }
}