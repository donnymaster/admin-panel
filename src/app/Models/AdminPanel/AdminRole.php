<?php

namespace App\Models\AdminPanel;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminRole extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }
}
