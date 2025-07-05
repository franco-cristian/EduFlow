<?php

namespace App\Http\Controllers;

use App\Models\ProjectFile;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function download(ProjectFile $file)
    {
        // Usa la policy para autorizar la acción
        $this->authorize('download', $file);

        // Usa el facade Storage para mayor seguridad y flexibilidad
        return Storage::download($file->stored_name, $file->original_name);
    }

    public function destroy(ProjectFile $file)
    {
        // Usa la policy para autorizar la acción
        $this->authorize('delete', $file);

        Storage::delete($file->stored_name);
        $file->delete(); // Eliminación física del registro en la BD

        return back()->with('message', 'Archivo eliminado correctamente.');
    }
}