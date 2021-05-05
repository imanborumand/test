<?php namespace App\Repositories;


use App\Exceptions\CustomQueryErrorException;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

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


    /**
     * @param int $month
     * @return array
     * @throws CustomQueryErrorException
     */
    public function transactionStatistics( int $month = 1) : array
    {
        return (array) DB::select( "SELECT
                                    SUM(CASE WHEN amount between 0 and 5000 THEN amount  END) amount1,
                                    SUM(CASE WHEN amount between 5000 and 10000 THEN amount  END)  amount2,
                                    SUM(CASE WHEN amount between 10000 and 100000 THEN amount  END ) amount3,
                                    SUM(CASE WHEN amount > 100000 THEN amount  END ) amount4
                                FROM transactions where created_at > " .Carbon::now()->subMonths($month))[0]  ?? throw new CustomQueryErrorException();

    }


    /**
     * @return array
     * @throws CustomQueryErrorException
     */
    public function summaryTransactions() : array
    {
        return  (array) DB::select( "SELECT
                                    SUM(amount) amount,
                                    SUM(CASE WHEN type='" . TRANSACTION_TYPES[0] ."' THEN amount  END)  web_count,
                                    SUM(CASE WHEN type='" . TRANSACTION_TYPES[1] ."' THEN amount  END ) mobile_count,
                                    SUM(CASE WHEN type='" . TRANSACTION_TYPES[2] ."' THEN amount  END ) pos_count
                                FROM transactions")[0] ?? throw new CustomQueryErrorException();
    }
}
