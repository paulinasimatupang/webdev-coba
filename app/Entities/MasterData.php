<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class MasterData.
 *
 * @package namespace App\Entities;
 */
class MasterData extends Model implements Transformable
{
    use TransformableTrait;

    public $incrementing = true;

    protected $fillable = [
        'id',
        'name',
        'description',
        'status'
    ];

    protected $table = 'groups_admin';
    protected $connection = 'pgsql_billiton';
    public $timestamps = false;

}