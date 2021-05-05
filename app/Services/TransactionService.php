<?php namespace App\Services;


use App\Exceptions\CustomQueryErrorException;
use App\Repositories\TransactionRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class TransactionService extends ServiceBase
{

    /**
     * TransactionService constructor.
     *
     * @param TransactionRepository $repository
     */
    public function __construct(TransactionRepository  $repository)
    {
        $this->repository = $repository;
    }


    /**
     * return transactions by type and amount
     * @param array $params
     * @return LengthAwarePaginator
     */
    public function getTransactions( array $params) : LengthAwarePaginator
    {
       return $this->repository->getTransactionsByTypeAndAmount($params['type'], $params['amount']);
    }


    /**
     * @return array
     * @throws CustomQueryErrorException
     */
    public function statistics() : array
    {
        return [
            'transactions' => $this->repository->transactionStatistics(),
            'summary' => $this->repository->summaryTransactions()
        ];
    }



}
