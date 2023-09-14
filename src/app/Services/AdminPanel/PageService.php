<?php

namespace App\Services\AdminPanel;

use App\Models\AdminPanel\Pages;
use Illuminate\Http\Request;

class PageService
{
    const MAX_ITEMS_FOR_PAGE = 5;

    public function create(Request $request)
    {
        $data = $request->safe();
        dd($data);
        return Pages::create($data);
    }

    /**
     * Получить список страниц в зависимости от поиска (q=) с пагинацией
     */
    public function getListPages(Request $request)
    {
        $query = $request->get('query');

        $pages = Pages::query()->when($query, function ($pages) use ($query) {
            $pages->where('name', 'like', "%$query%");
        })->paginate(self::MAX_ITEMS_FOR_PAGE, ['id', 'name']);

        return $pages;
    }
}
