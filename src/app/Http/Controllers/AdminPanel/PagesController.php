<?php

namespace App\Http\Controllers\AdminPanel;

use App\DataTables\AdminPanel\PageStatisticsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminPanel\CreatePageRequest;
use App\Http\Requests\AdminPanel\UpdatePageRequest;
use App\Models\AdminPanel\Page;
use App\Models\AdminPanel\Statistic;
use App\Services\AdminPanel\PageService;
use App\Services\AdminPanel\StatisticService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PagesController extends Controller
{
    private $service = null;

    public function __construct()
    {
        $this->service = new PageService();
    }
    public function index(PageStatisticsDataTable $pageStatisticsDataTable)
    {
        return $pageStatisticsDataTable->render('admin-panel.pages.page');
    }

    public function store(CreatePageRequest $request)
    {
        $this->service->create($request);

        return redirect()->route('admin.pages');
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

    public function validPages()
    {
        return Statistic::select('page_name_visit')->groupBy('page_name_visit')->get();
    }

    public function getValidDatePeriod()
    {
        return StatisticService::getValidDatePeriodPageStatistic();
    }

    public function removeStatistics(Request $request)
    {
        $lastDays = $request->get('last-days');

        Statistic::when($lastDays, function ($query) use ($lastDays) {
            $query->where('created_at', '>=', Carbon::now()->subDays($lastDays));
        })->delete();

        return [
            'message' => 'Записи были удалены!'
        ];
    }

    public function edit(Request $request, Page $page)
    {
        return view('admin-panel.pages.edit', compact('page'));
    }

    public function update(UpdatePageRequest $request, Page $page)
    {
        $data = $request->safe()->toArray();

        $checkName = Page::when($data['name'], fn ($query) => $query->orWhere('name', $data['name']))->get();

        if ($checkName->count()) {
            if ($checkName->first()->id != $page->id) {
                return back()->withErrors([
                    'name' => 'Такое имя используется!'
                ]);
            }
        }

        $checkRoute = Page::when($data['route'], fn ($query) => $query->orWhere('route', $data['route']))->get();

        if ($checkRoute->count()) {
            if ($checkRoute->first()->route != $page->route) {
                return back()->withErrors([
                    'route' => 'Такой адрес используется!'
                ]);
            }
        }

        $page->update($data);

        // images

        $this->service->updateImages($request, $page);

        return back()->with('successfully', 'Страница была обновлена!');
    }
}
