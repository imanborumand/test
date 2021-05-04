<?php namespace App\Repositories;


use App\Models\Transaction;
use Illuminate\Pagination\LengthAwarePaginator;

class TransactionRepository extends RepositoryBase
{

    public function __construct(Transaction  $transaction)
    {
        $this->model = $transaction;
    }


    /**
     * @param string $type
     * @param int    $amount
     * @return mixed
     */
    public function getTransactionsByTypeAndAmount( string $type, int $amount) : LengthAwarePaginator
    {
        return $this->model
            ->latest()
            ->where('type', $type)
            ->where('amount', $amount)
            ->paginate($this->customPaginateNumber);

    }

}
