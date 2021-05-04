<?php namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Services\TransactionService;

class TransactionController extends Controller
{

    /**
     * TransactionController constructor.
     *
     * @param TransactionService $transactionService
     */
    public function __construct( TransactionService  $transactionService)
    {

        $this->service = $transactionService;
    }


    public function all()
    {
        return '1';
    }



}
