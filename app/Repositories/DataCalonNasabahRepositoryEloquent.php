<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\DataCalonNasabahRepository;
use App\Entities\DataCalonNasabah;
use App\Validators\DataCalonNasabahValidator;

/**
 * Class DataCalonNasabahRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class DataCalonNasabahRepositoryEloquent extends BaseRepository implements DataCalonNasabahRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return DataCalonNasabah::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return DataCalonNasabahValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
