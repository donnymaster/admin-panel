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
        'promocode_id',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m',
    ];

    public function variants()
    {
        return $this
            ->belongsToMany(ProductVariant::class, 'product_orders', 'order_id')
            ->withPivot(['id', 'count_product'])
            ->withTimestamps();
    }

    public function promocode()
    {
        return $this->belongsTo(Promocode::class);
    }
}
