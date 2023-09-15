<?php

namespace App\Services\AdminPanel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class SiteSettingService
{
    const TINY_KEY_CONFIG_KEY = 'TINYMCE_KEY';
    CONST TINY_LINK_CONFIG_KEY = 'TINYMCE_LINK';

    public function updateTinyMCE(Request $request)
    {
        if ($request->has('tinymce_key')) {
            Config::set('app.tinymce_key', $request->get('tinymce_key'));
        }

        if ($request->has('tinymce_link')) {
            Config::set('app.tinymce_link', $request->get('tinymce_link'));
        }
    }
}
