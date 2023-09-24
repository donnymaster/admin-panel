<?php

namespace App\Http\Controllers\AdminPanel;

use App\DataTables\AdminPanel\SettingsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminPanel\SettingSiteRequest;
use App\Http\Requests\AdminPanel\UpdateSiteSettingRequest;
use App\Models\AdminPanel\SiteSetting;
use App\Services\AdminPanel\SiteSettingService;

class SettingSiteController extends Controller
{
    private $service = null;

    public function __construct()
    {
        $this->service = new SiteSettingService();
    }

    public function index(SettingsDataTable $settingsDataTable)
    {
        return $settingsDataTable->render('admin-panel.site-settings.index');
    }

    public function store(SettingSiteRequest $request)
    {
        SiteSetting::create($request->safe()->toArray());

        return [
            'message' => 'Переменная создана',
        ];
    }

    public function update(UpdateSiteSettingRequest $request, SiteSetting $setting)
    {
        $this->service->update($request->validated(), $setting);

        return back()->with(['message' => 'Данные успешно обновлены!']);
    }

    public function remove(SiteSetting $setting)
    {
        $setting->delete();

        return [
            'message' => 'Запись была удалена!',
        ];
    }
}
