@inject('service', 'App\Services\AdminPanel\SiteSettingService')

@if (!$service->getValueVariable('redaktor-tiny-url'))
    <br>
    Подключите TinyMCE установив переменную 'redaktor-tiny-url'
@endif
