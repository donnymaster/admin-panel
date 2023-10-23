<?php

namespace App\Models\AdminPanel;

use App\Traits\Model\DateFormatTimeZoneTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promocode extends Model
{
    use HasFactory, DateFormatTimeZoneTrait;

    protected $fillable = [
        'name',
        'status',
        'code',
        'quantity',
        'percentages',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
