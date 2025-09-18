<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'user_id',
        'status',
        'priority',
    ];

    // Связь с пользователем (назначенный)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Комментарии
    public function comments()
    {
        return $this->hasMany(TaskComment::class);
    }
}
