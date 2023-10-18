<?php

namespace App\Services\AdminPanel;

use Illuminate\Http\Request;

class ImageHandlerService
{
    private $slug_db = 'variant_image';



    public static function save()
    {

    }

    public static function delete()
    {

    }

    public static function saveImageByVariant(Request $request)
    {

    }

    private static function getSizeString($bytes, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB');

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1000));
        $pow = min($pow, count($units) - 1);

        $bytes /= pow(1000, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    private static function getPathProductVariant()
    {

    }
}
