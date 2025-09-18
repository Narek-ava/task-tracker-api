<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password',
    ];

    /**
     * Получить идентификатор, который будет храниться в subject claim токена.
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Возвращает кастомные клеймы для токена (можно оставить пустым массивом).
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

}
