<?php

namespace App\Models\AdminPanel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategoryProperty extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'slug',
        'sync_id',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m',
    ];

    public function values()
    {
        return $this->hasMany(PropertyValue::class);
    }

    public function categoryies()
    {
        return $this->belongsToMany(ProductCategory::class, 'category_properties', 'property_id', 'category_id');
    }
    public function categoryById($id)
    {
        return $this->belongsToMany(ProductCategory::class, 'category_properties', 'property_id', 'category_id')->wherePivot('category_id', $id);
    }
}
