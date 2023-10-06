<?php

namespace App\Models\AdminPanel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyValue extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_category_property_id',
        'value',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m',
    ];

    public function product_category()
    {
        return $this->belongsTo(ProductCategoryProperty::class);
    }

    public function property_value()
    {
        return $this->morphTo();
    }
}
