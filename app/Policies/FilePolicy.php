<?php

namespace App\Policies;

use App\Models\ProjectFile;
use App\Models\User;

class FilePolicy
{
    /**
     * Permite a los administradores realizar cualquier acción.
     */
    public function before(User $user, string $ability): bool|null
    {
        if ($user->isAdmin()) {
            return true;
        }
        return null;
    }

    /**
     * Determina si el usuario puede ver la información del archivo.
     */
    public function view(User $user, ProjectFile $projectFile): bool
    {
        // Puede ver la info del archivo si puede ver el proyecto.
        return $user->can('view', $projectFile->project);
    }

    /**
     * Determina si el usuario puede crear (subir) archivos para un proyecto.
     * La autorización real se hace en el componente al llamar $this->authorize('update', $this->project)
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determina si el usuario puede eliminar el archivo.
     */
    public function delete(User $user, ProjectFile $projectFile): bool
    {
        // Puede eliminar si es quien lo subió, el dueño del proyecto, o el profesor supervisor.
        return $user->id === $projectFile->uploaded_by ||
               $user->id === $projectFile->project->user_id ||
               $user->id === $projectFile->project->teacher_id;
    }

    /**
     * Determina si el usuario puede descargar el archivo.
     */
    public function download(User $user, ProjectFile $projectFile): bool
    {
        // Puede descargar si puede ver el proyecto.
        return $user->can('view', $projectFile->project);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ProjectFile $projectFile): bool
    {
        return false; // No implementado
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ProjectFile $projectFile): bool
    {
        return false; // No implementado
    }
}