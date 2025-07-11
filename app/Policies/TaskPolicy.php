<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;

class TaskPolicy
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
     * Determina si el usuario puede ver la tarea.
     */
    public function view(User $user, Task $task): bool
    {
        // Puede ver la tarea si puede ver el proyecto al que pertenece.
        return $user->can('view', $task->project);
    }

    /**
     * Determina si un usuario puede crear tareas para un proyecto.
     */
    public function create(User $user, Project $project): bool
    {
        // Puede crear una tarea si tiene permiso para actualizar el proyecto (dueño o supervisor).
        return $user->can('update', $project);
    }

    /**
     * Determina si el usuario puede actualizar la tarea.
     */
    public function update(User $user, Task $task): bool
    {
        // Puede actualizar la tarea si tiene permiso para actualizar el proyecto.
        return $user->can('update', $task->project);
    }

    /**
     * Determina si el usuario puede eliminar la tarea.
     */
    public function delete(User $user, Task $task): bool
    {
        // Puede eliminar la tarea si tiene permiso para actualizar el proyecto.
        return $user->can('update', $task->project);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Task $task): bool
    {
        return false; // No implementado
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Task $task): bool
    {
        return false; // No implementado
    }
}