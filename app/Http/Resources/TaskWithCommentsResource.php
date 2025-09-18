<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskWithCommentsResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'task' => new TaskResource($this),
            'comments' => TaskCommentResource::collection($this->comments),
        ];
    }
}
