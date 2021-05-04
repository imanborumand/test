<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Transactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('webservice_id');
            $table->foreign('webservice_id')->references('id')->on('webservices')->onDelete('cascade');
            $table->decimal('amount', 9, 3)->index();
            $table->enum('type', TRANSACTION_TYPES)->default(TRANSACTION_TYPES[0])->index();//0:web,1:mobile,2:pos
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
