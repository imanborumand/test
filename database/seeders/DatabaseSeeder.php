<?php

namespace Database\Seeders;

use App\Models\Transaction;
use App\Models\Webservice;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        Webservice::factory()->count(3)->create()->each(function($q) {
            Transaction::factory()->count(10)->create(['webservice_id'=>$q->id]);
        });

    }
}
