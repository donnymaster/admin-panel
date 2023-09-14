<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminPanel\CreatePageRequest;
use App\Services\AdminPanel\PageService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PagesController extends Controller
{
    private $service = null;

    public function __construct()
    {
        $this->service = new PageService();
    }
    public function index()
    {
        $pageName = '1';
        return view('admin-panel.pages.page', compact('pageName'));
    }

    public function store(CreatePageRequest $request)
    {

        $page = $this->service->create($request);

        // return view('admin.page.create', compact($page));
    }

    public function create()
    {
        return view('admin-panel.pages.create', ['title' => 'Создание страницы']);
    }

    public function pageList(Request $request)
    {
        $pages = $this->service->getListPages($request);

        return response()->json($pages, Response::HTTP_OK);
    }
}
