<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Services\AdminPanel\StatisticService;
use Illuminate\Http\Request;

class StatisticController extends Controller
{
    public function index()
    {
        $applicationPeriod = StatisticService::getMinMaxDatePeriodApplications();
        $reviewPeriod = StatisticService::getMinMaxDatePeriodReviews();

        return view('admin-panel.statistics.board', compact('applicationPeriod', 'reviewPeriod'));
    }

    public function informationPages(Request $request)
    {
        return StatisticService::getInformationPagesCountVisits($request);
    }
}
