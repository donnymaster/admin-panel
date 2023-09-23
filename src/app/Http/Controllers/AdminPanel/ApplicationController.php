<?php

namespace App\Http\Controllers\AdminPanel;

use App\DataTables\AdminPanel\ApplicationsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminPanel\UpdateApplicationRequest;
use App\Models\AdminPanel\Application;
use App\Services\AdminPanel\ApplicationService;

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

    public function info()
    {
        return response()->json($this->service->info());
    }
}
