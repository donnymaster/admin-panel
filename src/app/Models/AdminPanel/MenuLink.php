<?php

namespace App\Models\AdminPanel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'route',
        'parent',
        'is_show',
        'is_main_menu_link',
    ];

    public function isCurrentPage(): bool
    {
        return str_contains(request()->path(), trim(parse_url(route($this->route), PHP_URL_PATH), '/'));
    }

    public function parent()
    {
        return $this->hasOne(MenuLink::class, 'id', 'parent');
    }
}
