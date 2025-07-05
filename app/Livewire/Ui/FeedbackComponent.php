<?php

namespace App\Livewire\Ui;

use Livewire\Component;
use App\Models\Feedback;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class FeedbackComponent extends Component
{
    public $projectId;
    public $content = '';
    public $feedbacks = [];

    public function mount($projectId)
    {
        $this->projectId = $projectId;
        $this->loadFeedback();
    }

    public function loadFeedback()
    {
        $project = Project::findOrFail($this->projectId);
        $this->feedbacks = $project->feedback()->with('user')->latest()->get();
    }

    public function rules()
    {
        return [
            'content' => 'required|string|min:10|max:1000',
        ];
    }

    public function addFeedback()
    {
        $this->validate();

        Feedback::create([
            'content' => $this->content,
            'project_id' => $this->projectId,
            'user_id' => Auth::id(),
        ]);

        $this->reset('content');
        $this->loadFeedback();
        $this->dispatch('feedbackAdded');
    }

    public function render()
    {
        return view('livewire.feedback-component');
    }
}