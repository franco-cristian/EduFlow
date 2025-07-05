<?php

namespace App\Policies;

use App\Models\ProjectFile;
use App\Models\User;

class FilePolicy
{
    public function download(User $user, ProjectFile $file): bool
    {
        // Admin puede descargar todo
        if ($user->isAdmin()) {
            return true;
        }

        // El creador del proyecto, el profesor asignado o quien subió el archivo pueden descargarlo.
        return $user->id === $file->project->user_id
            || $user->id === $file->project->teacher_id
            || $user->id === $file->uploaded_by;
    }
    
    public function delete(User $user, ProjectFile $file): bool
    {
        // Solo quien subió el archivo o un admin puede eliminarlo.
        if ($user->isAdmin()) {
            return true;
        }
        return $user->id === $file->uploaded_by;
    }
}