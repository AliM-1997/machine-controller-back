<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskNotification extends Notification
{
    use Queueable;
    public $task;
    /**
     * Create a new notification instance.
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }


    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray($notifiable): array
    {
        return [
            'task_id' => $this->task->id,
            'user_id'=>$this->task->user_id,
            'machine_name'=>$this->task->name,
            'jobDescription' => $this->task->jobDescription,
            'assignedDate' => $this->task->assignedDate,
            'dueDate' => $this->task->dueDate,
            'location' => $this->task->location,
            'status' => $this->task->status,
        ];
    }
}
