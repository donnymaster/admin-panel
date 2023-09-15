<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminPanel\SettingSiteRequest;
use App\Services\AdminPanel\SiteSettingService;
use Illuminate\Http\Request;

class SettingSiteController extends Controller
{
    private $service = null;

    public function __construct()
    {
        $this->service = new SiteSettingService();
    }
    public function index()
    {
        return view('admin-panel.site-settings.index');
    }

    public function store(SettingSiteRequest $request)
    {
        // update tinymce
        $this->service->updateTinyMCE($request);

        return redirect()->route('admin.settings');
    }
}
