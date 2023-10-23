<?php

namespace App\Models\AdminPanel;

use App\Traits\Model\DateFormatTimeZoneTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyValue extends Model
{
    use HasFactory, DateFormatTimeZoneTrait;

    protected $fillable = [
        'product_category_property_id',
        'value',
    ];
    public function product_category()
    {
        return $this->belongsTo(ProductCategoryProperty::class, 'product_category_property_id');
    }

    public function property_value()
    {
        return $this->morphTo();
    }
}
