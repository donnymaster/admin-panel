<?php

namespace App\Services\AdminPanel;

use App\Models\AdminPanel\Page;
use App\Models\AdminPanel\Statistic;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Jenssegers\Agent\Agent;
use Stevebauman\Location\Facades\Location;

class PageService
{
    const MAX_ITEMS_FOR_PAGE = 5;
    const PATH_SAVE_IMAGE = 'pages/';
    const STORAGE_DISK = 'public';

    public function create(Request $request): Page
    {
        $data = $request->safe();
        $updatedData = [];

        $page = $this->simpeCreatePage($data);

        if ($data->has('og_image')) {
            $ogImageLink = $data['og_image']->store(self::PATH_SAVE_IMAGE . $page->id, self::STORAGE_DISK);
            $updatedData['og_image'] = $ogImageLink;
        }

        if ($data->has('og_vk_image')) {
            $ogImageVKLink = $data['og_vk_image']->store(self::PATH_SAVE_IMAGE . $page->id, self::STORAGE_DISK);
            $updatedData['og_vk_image'] = $ogImageVKLink;
        }

        if ($data->has('og_fb_image')) {
            $ogImageFBLink = $data['og_fb_image']->store(self::PATH_SAVE_IMAGE . $page->id, self::STORAGE_DISK);
            $updatedData['og_fb_image'] = $ogImageFBLink;
        }

        if ($data->has('og_twitter_image')) {
            $ogImageTWLink = $data['og_twitter_image']->store(self::PATH_SAVE_IMAGE . $page->id, self::STORAGE_DISK);
            $updatedData['og_twitter_image'] = $ogImageTWLink;
        }

        if ($updatedData) {
            $page->update($updatedData);
        }

        return $page;
    }

    /**
     * Получить список страниц в зависимости от поиска (query=) с пагинацией
     */
    public function getListPages(Request $request): LengthAwarePaginator
    {
        $query = $request->get('query');

        $pages = Page::query()->when($query, function ($pages) use ($query) {
            $pages->where('name', 'like', "%$query%");
        })->paginate(self::MAX_ITEMS_FOR_PAGE, ['id', 'name', 'route']);

        return $pages;
    }

    public static function takeSnapshotVisiter($url, $pageName)
    {

        $data = [];
        $agent = new Agent();
        $location = Location::get($_SERVER['REMOTE_ADDR']);

        if ($location) {
            $data = [
                'country_visitor' => $location->countryName,
                'city_visitor' => $location->cityName
            ];
        }

        Statistic::create([
            'ip_visitor' => $_SERVER['REMOTE_ADDR'],
            'user_agent' => $agent->getUserAgent(),
            'device_visitor' => $agent->isPhone() ? 'phone' : 'desktop',
            'os_visitor' => $agent->platform(),
            'os_version_visitor' => $agent->version($agent->platform()),
            'browser_visitor' => $agent->browser(),
            'browser_version_visitor' => $agent->version($agent->browser()),
            'page_name_visit' => $pageName,
            'page_url_visit' => $url,
            'country_visitor' => '-',
            'city_visitor' => '-',
            ...$data
        ]);
    }

    public function updateImages(Request $request, Page $page)
    {
        $data = [];

        if ($request->has('og_twitter_image')) {
            Storage::delete('public/'.$page->og_twitter_image);
            $data['og_twitter_image'] = $request->file('og_twitter_image')->store(self::PATH_SAVE_IMAGE . $page->id, self::STORAGE_DISK);
        }

        if ($request->has('og_fb_image')) {
            Storage::delete('public/'.$page->og_fb_image);
            $data['og_fb_image'] = $request->file('og_fb_image')->store(self::PATH_SAVE_IMAGE . $page->id, self::STORAGE_DISK);
        }

        if ($request->has('og_vk_image')) {
            Storage::delete('public/'.$page->og_vk_image);
            $data['og_vk_image'] = $request->file('og_vk_image')->store(self::PATH_SAVE_IMAGE . $page->id, self::STORAGE_DISK);
        }

        if ($request->has('og_image')) {
            Storage::delete('public/'.$page->og_image);
            $data['og_image'] = $request->file('og_image')->store(self::PATH_SAVE_IMAGE . $page->id, self::STORAGE_DISK);
        }

        if (count($data) >= 1) {
            $page->update($data);
        }
    }

    private function simpeCreatePage($data): Page
    {
        $fields = [
            'name',
            'route',
            'title',
            'description',
            'keywords',
            'old_route',
            'canonical_address',
            'og_title',
            'og_type',
            'og_url',
            'og_image',
            'og_description',
            'is_show',
            'is_track',
        ];

        return Page::create($data->only($fields));
    }
}
