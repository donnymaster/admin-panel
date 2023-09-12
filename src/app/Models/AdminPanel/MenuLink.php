<?php

namespace App\Models\AdminPanel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'route', 'parent', 'is_show'
    ];

    public function isCurrentPage(): bool
    {
        return trim(parse_url(route($this->route), PHP_URL_PATH), '/') === request()->path();
    }
}
