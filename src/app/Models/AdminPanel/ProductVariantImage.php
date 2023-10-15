<?php

namespace App\Models\AdminPanel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariantImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_variant_id',
        'slug',
        'path',
        'name',
        'parent_id'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m',
    ];

    public function productVariant()
    {
        return $this->belongsTo(Product::class);
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }
}
