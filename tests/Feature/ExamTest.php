<?php

namespace Tests\Feature;

use App\Models\Transaction;
use App\Models\Webservice;
use Tests\TestCase;

class ExamTest extends TestCase
{
    /**
     * @return void
     */
    public function test_pos_transaction_request()
    {
        $this->checkRequestTransactions(10000, TRANSACTION_TYPES[2]);
    }

    /**
     * @return void
     */
    public function test_web_transaction_request()
    {
        $this->checkRequestTransactions(1000, TRANSACTION_TYPES[0]);
    }


    /**
     * @return void
     */
    public function test_mobile_transaction_request()
    {
        $this->checkRequestTransactions(1000, TRANSACTION_TYPES[1]);
    }


    /**
     * @return void
     */
    public function test_get_last_month_statistics()
    {
        $response = $this->getJson('/api/v1/transactions/statistics');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
               'data' => [
                   'transactions' => [ // sum of amount beetween these ranges
                      'amount1',
                      'amount2',
                      'amount3',
                      'amount4',
                   ],
                   'summary' => [
                      'amount',
                      'web_count',
                      'pos_count',
                      'mobile_count',
                   ],
               ]
            ]);
    }


    /**
     * @param int    $amount
     * @param string $type
     */
    private function checkRequestTransactions( int $amount, string $type)
    {
        Webservice::factory()->count(1)->create()->each(function($q) use ($amount, $type) {
            Transaction::factory()->count(1)->create(['webservice_id'=>$q->id, 'amount' => $amount, 'type' => $type]);
        });

        $response = $this->postJson( '/api/v1/transactions/?type=' . $type, ['amount' => $amount]);
        $response->assertStatus(200)
                 ->assertJson([
                     'data' => [
                         0 => [
                             'type' => $type,
                             'amount' => $amount
                         ]
                     ]]);
    }
}
