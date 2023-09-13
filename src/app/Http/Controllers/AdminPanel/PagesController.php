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
        // return view();
    }

    public function store(CreatePageRequest $request)
    {
        $page = $this->service->create($request);

        return view('admin.page.create', compact($page));
    }

    public function pageList(Request $request)
    {
        $pages = $this->service->getListPages($request);

        return response()->json($pages, Response::HTTP_OK);
    }
}
