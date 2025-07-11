<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Project extends Model
{
    protected $fillable = [
        'title',
        'description',
        'status',
        'start_date',
        'end_date',
        'user_id',
        'teacher_id',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function feedbacks(): HasMany
    {
        return $this->hasMany(Feedback::class);
    }

    public function files(): HasMany
    {
        return $this->hasMany(ProjectFile::class);
    }

    protected function progress(): Attribute
    {
        return Attribute::make(
            get: function () {
                // Regla #1: Si el proyecto está marcado como completado, el progreso es 100%.
                if ($this->status === 'completed') {
                    return 100;
                }

                // Regla #2: Si no hay tareas, el progreso es 0%.
                $totalTasks = $this->tasks()->count();
                if ($totalTasks === 0) {
                    return 0;
                }

                // Regla #3: Si hay tareas, calcula el progreso basado en ellas.
                $completedTasks = $this->tasks()->where('status', 'completed')->count();
                return round(($completedTasks / $totalTasks) * 100);
            }
        );
    }
}
