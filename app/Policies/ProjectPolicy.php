<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;

class ProjectPolicy
{
    /**
     * Permite a los administradores realizar cualquier acción antes que las otras reglas.
     */
    public function before(User $user, string $ability): bool|null
    {
        if ($user->isAdmin()) {
            return true;
        }
        return null; // Si no es admin, deja que las otras reglas decidan.
    }

    /**
     * Determina si el usuario puede ver el proyecto.
     */
    public function view(User $user, Project $project): bool
    {
        // Puede ver si es el dueño (estudiante) O el profesor supervisor.
        return $user->id === $project->user_id || $user->id === $project->teacher_id;
    }

    /**
     * Determina si un usuario puede crear proyectos.
     */
    public function create(User $user): bool
    {
        // Solo los estudiantes pueden crear proyectos.
        return $user->role === 'student';
    }

    /**
     * Determina si el usuario puede actualizar el proyecto.
     */
    public function update(User $user, Project $project): bool
    {
        // Puede actualizar si es el dueño O el profesor supervisor.
        return $user->id === $project->user_id || $user->id === $project->teacher_id;
    }

    /**
     * Determina si el usuario puede eliminar el proyecto.
     */
    public function delete(User $user, Project $project): bool
    {
        // Solo el dueño (estudiante) puede eliminar su proyecto.
        return $user->id === $project->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Project $project): bool
    {
        return false; // No implementado
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Project $project): bool
    {
        return false; // No implementado
    }
}