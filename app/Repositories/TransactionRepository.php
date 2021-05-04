<?php namespace App\Repositories;


use App\Models\Transaction;

class TransactionRepository extends RepositoryBase
{

    public function __construct(Transaction  $transaction)
    {
        $this->model = $transaction;
    }

}
