<?php

namespace App\Services\AdminPanel;

use App\Models\AdminPanel\Application;

class ApplicationService
{
    public function create($data)
    {

    }

    public function update($id, $data)
    {

    }

    public function getNumberUnprocessedApplication()
    {
        $count = Application::where('processed', false)->count();

        if ($count >= 100) {
            return '+99';
        }

        return $count;
    }
}
