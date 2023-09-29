<?php

namespace App\Models\AdminPanel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategoryProperty extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'product_category_id',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
    ];

    public function values()
    {
        return $this->hasMany(PropertyValue::class);
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class);
    }
}