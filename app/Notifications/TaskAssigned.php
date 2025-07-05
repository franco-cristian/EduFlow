<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Task;

class TaskAssigned extends Notification implements ShouldQueue
{
    use Queueable;

    public $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('📌 Nueva tarea asignada: ' . $this->task->title)
            ->line('Se te ha asignado una nueva tarea en el proyecto: ' . $this->task->project->title)
            ->action('Ver Tarea', route('student.tasks.show', $this->task))
            ->line('Fecha límite: ' . $this->task->due_date->format('d/m/Y'));
    }

    public function toArray($notifiable)
    {
        return [
            'type' => 'task_assigned',
            'task_id' => $this->task->id,
            'project_id' => $this->task->project_id,
            'title' => 'Tarea asignada: ' . $this->task->title,
            'message' => 'Se te ha asignado una nueva tarea en el proyecto: ' . $this->task->project->title,
            'url' => route('student.tasks.show', $this->task)
        ];
    }
}