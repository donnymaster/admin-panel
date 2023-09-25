<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Services\AdminPanel\StatisticService;

class StatisticController extends Controller
{
    public function index()
    {
        $applicationPeriod = StatisticService::getMinMaxDatePeriodApplications();
        $reviewPeriod = StatisticService::getMinMaxDatePeriodReviews();

        return view('admin-panel.statistics.board', compact('applicationPeriod', 'reviewPeriod'));
    }
}
