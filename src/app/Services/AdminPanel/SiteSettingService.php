<?php

namespace App\Services\AdminPanel;

use App\Models\AdminPanel\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class SiteSettingService
{
    public function update($data, SiteSetting $setting): void
    {
        $setting->update($data);
    }
}
