<?php namespace App\Services;


use App\Repositories\WebserviceRepository;

class WebserviceService extends ServiceBase
{

    public function __construct(WebserviceRepository  $repository)
    {
        $this->repository = $repository;
    }

}
