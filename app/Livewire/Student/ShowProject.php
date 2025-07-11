<?php

namespace App\Livewire\Student;

use App\Models\Project;
use App\Models\ProjectFile;
use App\Models\Feedback;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

#[Layout('layouts.app')]
class ShowProject extends Component
{
    use WithFileUploads;

    public Project $project;

    // Propiedades para los archivos
    public $files = [];
    public $fileInputId;

    // Propiedades para el feedback
    public $feedbackContent = '';

    // Listeners para refrescar partes de la página
    #[On('projectUpdated')]
    #[On('taskSaved')]
    #[On('fileUploaded')]
    #[On('feedbackAdded')]
    public function refreshProject()
    {
        $this->project->refresh();
    }

    public function mount(Project $project)
    {
        // ***** SOLUCIÓN DEFINITIVA: AUTORIZACIÓN MANUAL *****
        $user = Auth::user();
        
        // Verificamos si el usuario es el dueño, el profesor asignado, o un administrador.
        // Si no cumple ninguna de estas condiciones, lanzamos un error 403.
        if ($user->id !== $project->user_id && $user->id !== $project->teacher_id && !$user->isAdmin()) {
            abort(403, 'Acceso no autorizado.');
        }

        $this->project = $project->load('files', 'feedbacks.user', 'tasks.assignee');
        $this->fileInputId = 'file-upload-' . uniqid();
    }

    // --- LÓGICA DE ARCHIVOS (MOVIMOS LA LÓGICA DE FileUploader AQUÍ) ---

    public function uploadFiles()
    {
        $this->validate([
            'files.*' => 'required|file|max:10240',
        ]);

        $this->authorize('update', $this->project);

        foreach ($this->files as $file) {
            // Volvemos a usar el disco 'local' (o no especificamos ninguno, ya que es el por defecto)
            $storedName = $file->store('project_files/' . $this->project->id, 'local');

            $this->project->files()->create([
                'original_name' => $file->getClientOriginalName(),
                'stored_name'   => $storedName,
                'mime_type'     => $file->getMimeType(),
                'size'          => $file->getSize(),
                'uploaded_by'   => Auth::id(),
            ]);
        }

        $this->reset('files');
        session()->flash('message', 'Archivos subidos correctamente.');
        $this->dispatch('fileUploaded');
    }

    public function deleteFile($fileId)
    {
        $file = ProjectFile::findOrFail($fileId);
        $this->authorize('delete', $file);

        Storage::delete($file->stored_name);
        $file->delete();

        session()->flash('message', 'Archivo eliminado.');
        $this->project->refresh(); // Refresca el proyecto para actualizar la lista de archivos
    }

    // --- LÓGICA DE FEEDBACK (MOVIMOS LA LÓGICA DE FeedbackComponent AQUÍ) ---

    public function addFeedback()
    {
        $this->validate([
            'feedbackContent' => 'required|string|min:5|max:1000',
        ]);

        Feedback::create([
            'project_id' => $this->project->id,
            'user_id'    => Auth::id(),
            'content'    => $this->feedbackContent,
        ]);

        $this->reset('feedbackContent');
        session()->flash('message', 'Comentario añadido.');
        $this->dispatch('feedbackAdded'); // Para auto-refrescar
    }

    public function render()
    {
        // La vista ahora tiene toda la data que necesita a través de $this->project
        return view('livewire.student.show-project')
            ->title('Proyecto: ' . $this->project->title);
    }
}
