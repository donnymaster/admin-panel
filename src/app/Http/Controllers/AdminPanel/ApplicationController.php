<?php

namespace App\Http\Controllers\AdminPanel;

use App\DataTables\AdminPanel\ApplicationsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminPanel\UpdateApplicationRequest;
use App\Models\AdminPanel\Application;
use App\Services\AdminPanel\ApplicationService;
use App\Services\AdminPanel\StatisticService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    private $service = null;

    public function __construct()
    {
        $this->service = new ApplicationService();
    }

    public function index(ApplicationsDataTable $applicationsDataTable)
    {
        return $applicationsDataTable->render('admin-panel.applications.index', $this->service->info());
    }

    public function store(UpdateApplicationRequest $request, Application $application)
    {
        $application->update($request->safe()->toArray());
    }

    public function remove(Application $application)
    {
        $application->delete();

        return ['message' => 'Заявка была удалена'];
    }

    public function dateLimit(Request $request)
    {
        $dates = [
            'min' => $request->get('min'),
            'max' => $request->get('max'),
        ];

        // ограничение на загрузку на последние 30 дней при открытии страницы [is-first-load=true]
        if ($request->has('is-first-load')) {
            $lastDate = Carbon::create($dates['max'])->subDays(30);
            $dates['min'] = $lastDate->gt(Carbon::create($dates['min'])) ? $lastDate->format('Y-m-d') : $dates['min'];
        }

        return StatisticService::getCountApplicationsByPeriod($dates);
    }

    public function getInformationReviews()
    {
        return StatisticService::getInfoReviews();
    }

    public function info()
    {
        return response()->json($this->service->info());
    }
}
