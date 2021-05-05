<?php

use App\Http\Controllers\Api\TransactionController;
use Illuminate\Support\Facades\Route;






Route::prefix( '/v1/transactions' )->group( function() {

    Route::post('/', [TransactionController::class, 'getTransactions']);
    Route::get('/statistics/', [TransactionController::class, 'statistics']); //return statistics of transactions of last month
});


Route::prefix( '/v1/webservices' )->group( function() {

});
