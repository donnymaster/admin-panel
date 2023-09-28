<?php

namespace App\Services\AdminPanel;

use App\Models\AdminPanel\Application;
use App\Models\AdminPanel\Review;
use Carbon\Carbon;
use Illuminate\Support\Arr;
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

    public static function getInformationPagesCountVisits($request)
    {
        $currentDate = $request->get('end-date', Carbon::now()->format('Y-m-d'));
        $lastDate = $request->get('start-date', Carbon::now()->subDays(30)->format('Y-m-d'));

        $pages = [];

        if ($request->get('pages')) {
            $pages = $request->get('pages');
        }

        if ($pages) {
            $str = '';

            foreach ($pages as $index => $page) {
                $str .= '?,';
            }

           $str = substr($str, 0, -1);
//
            return DB::select(
                'select count(*) as count, DATE(created_at) as date, page_name_visit
                from statistics
                where page_name_visit in ('.$str.') and created_at BETWEEN ? and ?
                GROUP by DATE(created_at), page_name_visit',
                Arr::flatten([$pages, [$lastDate, $currentDate]]),
            );
        }

        return DB::select(
            'select count(*) as count, DATE(created_at) as date, page_name_visit
            from statistics
            where created_at BETWEEN ? AND ?
            GROUP by DATE(created_at), page_name_visit;',
            [
                $lastDate,
                $currentDate,
            ]
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
