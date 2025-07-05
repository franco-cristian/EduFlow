<?php

namespace App\Livewire\Ui;

use App\Models\Project;
use App\Models\ProjectFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class FileUploader extends Component
{
    use WithFileUploads;

    public $projectId;
    public $files = [];
    public $description = '';

    public function mount($projectId)
    {
        $this->projectId = $projectId;
    }

    public function rules()
    {
        return [
            'files.*' => 'required|file|max:10240', // 10MB
            'description' => 'nullable|string|max:255',
        ];
    }

    public function save()
    {
        $this->validate();

        $project = Project::findOrFail($this->projectId);
        $this->authorize('update', $project); // El usuario debe poder actualizar el proyecto para añadir archivos

        foreach ($this->files as $file) {
            $storedName = $file->store('project_files', 'local');

            $project->files()->create([
                'original_name' => $file->getClientOriginalName(),
                'stored_name' => $storedName,
                'mime_type' => $file->getMimeType(),
                'size' => $file->getSize(),
                'description' => $this->description,
                'uploaded_by' => Auth::id(),
            ]);
        }

        $this->reset(['files', 'description']);
        session()->flash('message', 'Archivos subidos correctamente');
        $this->dispatch('filesUploaded');
    }

    public function deleteFile($fileId)
    {
        $file = ProjectFile::findOrFail($fileId);
        $this->authorize('delete', $file); // Usamos FilePolicy

        Storage::disk('local')->delete($file->stored_name);
        $file->delete();

        session()->flash('message', 'Archivo eliminado');
        $this->dispatch('fileDeleted');
    }

    public function render()
    {
        $project = Project::findOrFail($this->projectId);
        return view('livewire.file-uploader', [
            'projectFiles' => $project->files
        ]);
    }
}