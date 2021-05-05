<?php namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Webservice extends Model
{
    use HasFactory;

    protected $table    = 'webservices';

    protected $fillable = [
        //     Column   |              Type              | Collation | Nullable |                 Default
        //------------+--------------------------------+-----------+----------+-----------------------------------------
        // id           | bigint                         |           | not null | nextval('webservices_id_seq'::regclass)
        'name',       //| character varying(255)         |           | not null |
        // created_at   | timestamp(0) without time zone |           |          |
        // updated_at   | timestamp(0) without time zone |           |          |
    ];




    //relations
    /**
     * @return HasMany
     */
    public function transactions() : HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    
}
