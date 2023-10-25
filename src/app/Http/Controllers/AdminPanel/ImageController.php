<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Services\AdminPanel\ImageHandlerService;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    /**
     * @var ImageHandlerService;
     */
    private $imageService = null;

    public function __construct()
    {
        $this->imageService = new ImageHandlerService();
    }

    public function create(Request $request)
    {
        return response(
            $this->imageService->create($request)
        );
    }
}
