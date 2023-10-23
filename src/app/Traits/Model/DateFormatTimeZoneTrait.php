<?php

namespace App\Traits\Model;

use Carbon\Carbon;

trait DateFormatTimeZoneTrait
{
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->timezone(config('app.timezone'))->format('Y-m-d H:i:s');
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->timezone(config('app.timezone'))->format('Y-m-d H:i:s');
    }
}
