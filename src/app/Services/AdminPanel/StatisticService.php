<?php

namespace App\Services\AdminPanel;

use App\Models\AdminPanel\Application;
use App\Models\AdminPanel\Review;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class StatisticService
{
    public static function getMinMaxDatePeriodApplications(): array
    {
        $minDate = Application::min('created_at');
        $maxDate = Application::max('created_at');

        return self::_getValidDate($minDate, $maxDate);
    }

    public static function getMinMaxDatePeriodReviews(): array
    {
        $minDate = Review::min('created_at');
        $maxDate = Review::max('created_at');

        return self::_getValidDate($minDate, $maxDate);
    }

    public static function getCountApplicationsByPeriod(array $dates)
    {
        return self::_getInformationByPeriod('applications', $dates);
    }

    public static function getCountReviewsByPeriod(array $dates)
    {
        return self::_getInformationByPeriod('reviews', $dates);
    }

    private static function _getInformationByPeriod(string $tableName, array $dates)
    {
        return DB::table($tableName)
        ->select(DB::raw('count(*) as count, DATE(created_at) as date'))
        ->whereBetween('created_at', [$dates['min'], $dates['max']])
        ->groupBy(['created_at'])
        ->orderBy('created_at')
        ->get();
    }

    private static function _getValidDate($min, $max): array
    {
        $dates = [];

        if ($min) {
            $dates['min'] = Carbon::parse($min)->format('Y-m-d');
        } else {
            $dates['min']  = '1970-01-01';
        }

        if ($max) {
            $dates['max'] = Carbon::parse($max)->format('Y-m-d');
        } else {
            $dates['max']  = '1970-01-02';
        }

        return $dates;
    }

}
