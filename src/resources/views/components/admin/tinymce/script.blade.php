@inject('service', 'App\Services\AdminPanel\SiteSettingService')

@if ($service->getValueVariable('redaktor-tiny-url'))
    <script src="{{ $service->getValueVariable('redaktor-tiny-url') }}" referrerpolicy="origin"></script>
@endif
