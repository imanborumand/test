<?php namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\GetTransactionsRequest;
use App\Services\TransactionService;
use Illuminate\Http\JsonResponse;


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


    public function getTransactions(GetTransactionsRequest  $request) : JsonResponse
    {
        return $this->successResponse()
                    ->setData($this->service->getTransactions($request->validated()))
                    ->response();
    }

}
