<?php

namespace App\DTO\Task;

class TaskCommentDTO
{
    public string $comment;
    public int $user_id;

    public function __construct(array $data)
    {
        $this->comment = $data['comment'];
        $this->user_id = $data['user_id'];
    }
}
