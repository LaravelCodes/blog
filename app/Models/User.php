<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'number',
        'type',
    ];

    protected $hidden = [
        // 'password',
        'created_at',
        'updated_at',
        'is_deleted',
        'is_verified'
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

}
