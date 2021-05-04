<?php namespace App\Services;


use App\Repositories\TransactionRepository;

class TransactionService extends ServiceBase
{

    public function __construct(TransactionRepository  $repository)
    {
        $this->repository = $repository;
    }


}
