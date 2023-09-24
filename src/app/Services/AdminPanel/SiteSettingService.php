<?php

namespace App\Services\AdminPanel;

use App\Models\AdminPanel\SiteSetting;


class SiteSettingService
{
    public function update($data, SiteSetting $setting): void
    {
        $setting->update($data);
    }

    public function getValueVariable($slug): string | bool
    {
        $variable = SiteSetting::where('setting_key', $slug)->first();

        if (!$variable) {
            return false;
        }

        return $variable->setting_value;
    }
}
