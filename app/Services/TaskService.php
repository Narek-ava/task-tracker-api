<?php

namespace App\Services;

use App\DTO\Task\TaskCommentDTO;

use App\DTO\Task\TaskCreateDTO;
use App\DTO\Task\TaskUpdateStatusDTO;
use App\Jobs\SendTaskNotificationJob;
use App\Models\Task;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class TaskService
{
    public function listTasks(array $filters): Collection
    {
        return Task::query()
            ->when($filters['status'] ?? null, fn($q, $status) => $q->where('status', $status))
            ->when($filters['priority'] ?? null, fn($q, $priority) => $q->where('priority', $priority))
            ->when($filters['user_id'] ?? null, fn($q, $user_id) => $q->where('user_id', $user_id))
            ->orderByDesc('created_at')
            ->get();
    }

    public function createTask(TaskCreateDTO $dto): Task
    {
        $user = $dto->user_id ? User::find($dto->user_id) : User::where('position', 'manager')->first();

        $task = Task::create([
            'title' => $dto->title,
            'description' => $dto->description,
            'user_id' => $user->id,
            'priority' => $dto->priority,
            'status' => $dto->priority === 'high' ? 'in_progress' : 'new',
        ]);

        if ($task->priority === 'high') {
            SendTaskNotificationJob::dispatch($task->id, 'task_assigned');
        }

        return $task;
    }

    public function updateStatus(Task $task, TaskUpdateStatusDTO $dto): Task
    {
        $user = $dto->user_id ? User::find($dto->user_id) : null;

        $task->update([
            'status' => $dto->status,
        ]);

        if ($dto->status === 'completed' && $user) {
            $task->comments()->create([
                'user_id' => $user->id,
                'comment' => "Task completed by {$user->name}"
            ]);
        }

        SendTaskNotificationJob::dispatch($task->id, 'status_changed');
        return $task;
    }

    public function addComment(Task $task, TaskCommentDTO $dto)
    {
        if ($task->status === 'cancelled') {
            throw new Exception("Cannot add comments to cancelled task");
        }

        return $task->comments()->create([
            'user_id' => $dto->user_id,
            'comment' => $dto->comment
        ]);
    }

    public function getTaskWithComments(Task $task): Task
    {
        return $task->load('comments.user');
    }
}

