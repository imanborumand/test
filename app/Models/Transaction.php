<?php namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table    = 'transactions';

    protected $fillable = [
        //    Column       |              Type              | Collation | Nullable |                 Default
        //---------------+--------------------------------+-----------+----------+------------------------------------------
        // id              | bigint                         |           | not null | nextval('transactions_id_seq'::regclass)
        'webservice_id', //| bigint                         |           | not null |
        'amount',        //| numeric(9,3)                   |           | not null |
        'type',          //| character varying(255)         |           | not null | 'WEB'::character varying
        // created_at      | timestamp(0) without time zone |           |          |
        // updated_at      | timestamp(0) without time zone |           |          |
    ];

}
