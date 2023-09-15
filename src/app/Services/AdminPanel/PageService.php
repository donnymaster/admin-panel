<?php

namespace App\Services\AdminPanel;

use App\Models\AdminPanel\Pages;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class PageService
{
    const MAX_ITEMS_FOR_PAGE = 5;
    const PATH_SAVE_IMAGE = 'pages/';
    const STORAGE_DISK = 'public';

    public function create(Request $request): Pages
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
     * Получить список страниц в зависимости от поиска (q=) с пагинацией
     */
    public function getListPages(Request $request): LengthAwarePaginator
    {
        $query = $request->get('query');

        $pages = Pages::query()->when($query, function ($pages) use ($query) {
            $pages->where('name', 'like', "%$query%");
        })->paginate(self::MAX_ITEMS_FOR_PAGE, ['id', 'name']);

        return $pages;
    }

    private function simpeCreatePage($data): Pages
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
        ];

        return Pages::create($data->only($fields));
    }
}
