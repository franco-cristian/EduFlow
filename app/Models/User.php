<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Asegúrate de que 'role' esté aquí si lo asignas masivamente
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // --- MÉTODOS DE ROL ---

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isTeacher(): bool
    {
        return $this->role === 'teacher';
    }

    // --- RELACIONES ---

    /**
     * Los proyectos que este usuario ha creado (como estudiante).
     */
    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    /**
     * Las tareas que este usuario tiene asignadas.
     */
    public function tasks()
    {
        return $this->hasMany(Task::class, 'assigned_to');
    }
    
    /**
     * Los comentarios de feedback que este usuario ha escrito.
     */
    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }
    
    /**
     * Los archivos que este usuario ha subido.
     */
    public function files()
    {
        return $this->hasMany(ProjectFile::class, 'uploaded_by');
    }

    /**
     * AÑADIR ESTA NUEVA RELACIÓN
     * Los proyectos que este usuario supervisa (como profesor).
     */
    public function supervisedProjects()
    {
        // Un usuario (profesor) tiene muchos proyectos, conectados a través de la clave foránea 'teacher_id'.
        return $this->hasMany(Project::class, 'teacher_id');
    }
}