<?php

namespace App\Services\AdminPanel;

use App\Models\AdminPanel\Application;

class ApplicationService
{
    const LIMIT_MAX_COUNT_APPLICATION = 100;

    const MAX_COUNT_APPLICATION = '+99';

    public function create($data)
    {

    }

    public function update($id, $data)
    {

    }

    public function getNumberUnprocessedApplication()
    {
        $count = Application::where('processed', false)->count();

        if ($count >= self::LIMIT_MAX_COUNT_APPLICATION) {
            return self::MAX_COUNT_APPLICATION;
        }

        return $count;
    }
}
