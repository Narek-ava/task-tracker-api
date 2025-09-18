<?php

namespace App\DTO\Task;

class TaskUpdateStatusDTO {
    public string $status;
    public ?int $user_id;

    public function __construct(array $data) {
        $this->status = $data['status'];
        $this->user_id = $data['user_id'] ?? null;
    }
}
