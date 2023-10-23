<?php

namespace App\Models\AdminPanel;

use App\Traits\Model\DateFormatTimeZoneTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategoryProperty extends Model
{
    use HasFactory, DateFormatTimeZoneTrait;

    protected $fillable = [
        'name',
        'description',
        'slug',
        'sync_id',
    ];

    public function values()
    {
        return $this->hasMany(PropertyValue::class);
    }

    public function countValues()
    {
        return $this->hasMany(PropertyValue::class)->count();
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
