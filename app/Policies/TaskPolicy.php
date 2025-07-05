<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use App\Models\Project;

class TaskPolicy
{
    /**
     * Un administrador puede realizar cualquier acción.
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
     * El usuario debe poder ver el proyecto al que pertenece la tarea.
     */
    public function view(User $user, Task $task): bool
    {
        return $user->can('view', $task->project);
    }

    /**
     * Determina si un usuario puede crear tareas para un proyecto.
     * Solo el creador del proyecto o el profesor asignado.
     */
    public function create(User $user, Project $project): bool
    {
        return $user->id === $project->user_id || $user->id === $project->teacher_id;
    }

    /**
     * Determina si el usuario puede actualizar la tarea.
     * Solo el creador del proyecto o el profesor asignado.
     */
    public function update(User $user, Task $task): bool
    {
        return $user->id === $task->project->user_id || $user->id === $task->project->teacher_id;
    }

    /**
     * Determina si el usuario puede eliminar la tarea.
     * Solo el creador del proyecto o el profesor asignado.
     */
    public function delete(User $user, Task $task): bool
    {
        return $user->id === $task->project->user_id || $user->id === $task->project->teacher_id;
    }
}