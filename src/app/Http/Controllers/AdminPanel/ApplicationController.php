<?php

namespace App\Http\Controllers\AdminPanel;

use App\DataTables\AdminPanel\ApplicationsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminPanel\UpdateApplicationRequest;
use App\Models\AdminPanel\Application;

class ApplicationController extends Controller
{
    public function index(ApplicationsDataTable $applicationsDataTable)
    {
        $processed = Application::where('processed', true)->count();
        $notProcessed = Application::where('processed', false)->count();

        return $applicationsDataTable->render('admin-panel.applications.index', compact('processed', 'notProcessed'));
    }

    public function store(UpdateApplicationRequest $request, Application $application)
    {
        $application->update($request->safe());
    }

    public function remove(Application $application)
    {
        $application->delete();

        return ['message' => 'Заявка была удалена'];
    }
}
