<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\AdminPanel\AdminRole;
use App\Services\AdminPanel\UserService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use  HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'created_at' => 'datetime:Y-m-d',
    ];

    public function role()
    {
        return $this->belongsTo(AdminRole::class);
    }

    public function isAdmin()
    {
        return $this->role()->first()->slug === UserService::ROLE_ADMIN;
    }

    public function isSuperAdmin()
    {
        return $this->role()->first()->slug === UserService::ROLE_SUPER_ADMIN;
    }

    public function isManager()
    {
        return $this->role()->first()->slug === UserService::ROLE_MANAGER;
    }
}
