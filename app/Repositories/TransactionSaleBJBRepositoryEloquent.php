<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\TransactionBJBRepository;
use App\Entities\TransactionBJB;
use App\Entities\TransactionLog;
use App\Validators\TransactionBJBValidator;
use App\Validators\TransactionSaleBJBValidator;

/**
 * Class TransactionBJBRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class TransactionSaleBJBRepositoryEloquent extends BaseRepository implements TransactionSaleBJBRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TransactionLog::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return TransactionSaleBJBValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
