<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;

class ProjectPolicy
{
    /**
     * Un administrador puede realizar cualquier acción.
     */
    public function before(User $user, string $ability): bool|null
    {
        if ($user->isAdmin()) { // Suponiendo que tienes un método isAdmin() en el modelo User
            return true;
        }
        return null; // Dejar que la policy decida
    }

    /**
     * Determina si el usuario puede ver el proyecto.
     */
    public function view(User $user, Project $project): bool
    {
        // El creador del proyecto, el profesor asignado o un admin pueden verlo.
        return $user->id === $project->user_id || $user->id === $project->teacher_id;
    }

    /**
     * Determina si un usuario puede crear proyectos.
     * Por ahora, solo estudiantes.
     */
    public function create(User $user): bool
    {
        return $user->role === 'student';
    }

    /**
     * Determina si el usuario puede actualizar el proyecto.
     */
    public function update(User $user, Project $project): bool
    {
        // Solo el estudiante que lo creó puede editarlo.
        return $user->id === $project->user_id;
    }

    /**
     * Determina si el usuario puede eliminar el proyecto.
     */
    public function delete(User $user, Project $project): bool
    {
        // Solo el estudiante que lo creó puede eliminarlo.
        return $user->id === $project->user_id;
    }
}