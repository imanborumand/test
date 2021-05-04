<?php namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Services\WebserviceService;

class WebserviceController extends Controller
{

    public function __construct(WebserviceService $service)
    {
        $this->service = $service;
    }


}
