<?php

namespace App\Jobs;

use App\Models\Task;
use App\Models\TaskNotifications;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendTaskNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected int $taskId;
    protected string $notificationType;

    public function __construct(int $taskId, string $notificationType)
    {
        $this->taskId = $taskId;
        $this->notificationType = $notificationType;
    }

    public function handle()
    {
        $task = Task::find($this->taskId);
        Log::info('job',[$this->taskId,$this->notificationType,$task]);
        if (!$task) return;

        $managers = User::where('position', 'manager')->get();

        foreach ($managers as $manager) {
            TaskNotifications::create([
                'task_id' => $task->id,
                'user_id' => $manager->id,
                'message' => $this->getMessage($task, $manager),
            ]);

            Log::info("Notification for manager {$manager->id}: {$this->notificationType}");
        }
    }

    protected function getMessage(Task $task, $manager): string
    {
        return match ($this->notificationType) {
            'status_changed' => "Status of task '{$task->title}' changed to {$task->status}",
            'task_assigned' => "Task '{$task->title}' assigned",
            'overdue' => "Task '{$task->title}' is overdue",
            default => "Notification for task '{$task->title}'",
        };
    }
}
