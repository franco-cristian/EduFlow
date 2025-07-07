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

    public Project $project; // Usamos el modelo completo
    public $files = [];
    public $description = '';

    // El método mount ahora recibe el objeto Project
    public function mount(Project $project)
    {
        $this->project = $project;
    }

    public function rules()
    {
        return [
            'files.*' => 'required|file|max:10240',
            'description' => 'nullable|string|max:255',
        ];
    }

    public function save()
    {
        $this->validate();

        // Ya no necesitamos buscar el proyecto, ya lo tenemos
        $this->authorize('update', $this->project); 

        foreach ($this->files as $file) {
            $storedName = $file->store('project_files/' . $this->project->id, 'local'); // Guardamos en una subcarpeta por proyecto

            $this->project->files()->create([
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
        // Usamos $this->dispatch para notificar a otros componentes si es necesario
        $this->dispatch('filesUploaded');
    }

    public function deleteFile($fileId)
    {
        $file = ProjectFile::findOrFail($fileId);
        $this->authorize('delete', $file);

        Storage::disk('local')->delete($file->stored_name);
        $file->delete();

        session()->flash('message', 'Archivo eliminado');
        $this->dispatch('fileDeleted');
    }

    public function render()
    {
        // Forzamos la recarga de la relación para tener los archivos más recientes
        $this->project->refresh();
        return view('livewire.ui.file-uploader', [
            'projectFiles' => $this->project->files
        ]);
    }
}