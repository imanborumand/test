<?php namespace App\Repositories;

/*
 * base repository
 * other repository extend from this class
 */

use Illuminate\Database\Eloquent\Model;

abstract class RepositoryBase
{

    /**
     * @var Model|null
     */
    protected ?Model $model = null;


    protected int $customPaginateNumber = 20;
}
