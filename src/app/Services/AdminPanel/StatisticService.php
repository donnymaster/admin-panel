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

    public static function getInfoReviews()
    {
        return DB::select('select count(*) count, rating from reviews GROUP by rating ORDER by rating');
    }

    public static function getInformationPagesCountVisits()
    {
        return DB::select(
            'select count(*) as count, DATE(created_at) as date, page_name_visit
            from statistics
            GROUP by DATE(created_at), page_name_visit;'
        );
    }

    private static function _getInformationByPeriod(string $tableName, array $dates)
    {

        return DB::select(
            "select count(*) as count, DATE(created_at) as date
            from  $tableName
            where created_at BETWEEN DATE(?) and DATE (?)
            GROUP by DATE(created_at)
            order by DATE(created_at)",
            [
                $dates['min'],
                $dates['max']
            ]

        );
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
