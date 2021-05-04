<?php namespace App\Repositories;


use App\Models\Webservice;

class WebserviceRepository extends RepositoryBase
{

    public function __construct(Webservice  $webservice)
    {
        $this->model = $webservice;
    }

}
