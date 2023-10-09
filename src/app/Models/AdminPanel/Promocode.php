<?php

namespace App\Models\AdminPanel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promocode extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
        'code',
        'quantity',
        'percentages',
        'product_variant_id',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m',
    ];

    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class);
    }
}
