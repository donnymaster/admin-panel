<?php

namespace App\Models\AdminPanel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_name',
        'status',
        'phone_number',
        'total_quantity',
        'delivery_address',
        'type_delivery',
        'user_annotation',
        'admin_annotation',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m',
    ];
}
