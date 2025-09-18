<?php
namespace App\DTO\Task;

class TaskCreateDTO {
    public string $title;
    public ?string $description;
    public ?int $user_id;
    public string $priority;

    public function __construct(array $data) {
        $this->title = $data['title'];
        $this->description = $data['description'] ?? null;
        $this->user_id = $data['user_id'] ?? null;
        $this->priority = $data['priority'] ?? 'normal';
    }
}
