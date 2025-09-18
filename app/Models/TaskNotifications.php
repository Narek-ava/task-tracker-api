<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskNotifications extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'user_id',
        'message',
    ];

    // Связь с задачей
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
