<?php

namespace App\Http\Controllers\AdminPanel;

use App\DataTables\AdminPanel\SettingsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminPanel\SettingSiteRequest;
use App\Http\Requests\AdminPanel\UpdateSiteSettingRequest;
use App\Models\AdminPanel\SiteSetting;
use App\Services\AdminPanel\SiteSettingService;
use Illuminate\Http\Request;

class SettingSiteController extends Controller
{
    private $service = null;

    public function __construct()
    {
        $this->service = new SiteSettingService();
    }

    public function index(SettingsDataTable $settingsDataTable)
    {
        // // TODO: добавить возможность пагинации, потому что не известно сколько будет настроек
        // $settings = SiteSetting::get();

        // return view('admin-panel.site-settings.index', compact('settings'));
        return $settingsDataTable->render('admin-panel.site-settings.index');
    }

    public function store(SettingSiteRequest $request)
    {
        // update tinymce

        return redirect()->route('admin.settings');
    }

    public function update(UpdateSiteSettingRequest $request, SiteSetting $setting)
    {
        $this->service->update($request->validated(), $setting);

        return back()->with(['message' => 'Данные успешно обновлены!']);
    }
}
