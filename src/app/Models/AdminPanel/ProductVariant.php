<?php

namespace App\Models\AdminPanel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'page_title',
        'name_tile',
        'price',
        'count',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function values()
    {
        return $this->morphMany(PropertyValue::class, 'property_value');
    }
}
