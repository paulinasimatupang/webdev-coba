<?php

namespace App\Entities;

use Auth;
use Illuminate\Database\Eloquent\Model;
use App\Presenters\ShareholderPresenter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Shareholder.
 *
 * @package namespace App\Entities;
 */
class Shareholder extends Model implements Transformable
{
    use TransformableTrait;
    use SoftDeletes;

    protected $presenter = ShareholderPresenter::class;
    public $incrementing = true;

    protected $fillable = [
        'id',
        'name'
    ];

    protected $table = 'shareholders';

}
