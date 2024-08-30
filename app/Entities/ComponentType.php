<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class TerminalType.
 *
 * @package namespace App\Entities;
 */
class ComponentType extends Model implements Transformable
{
    use TransformableTrait;
    protected $connection = 'pgsql_billiton';
    protected $table = 'reff_component_type';
    protected $primaryKey = 'component_type_id';
    public $incrementing = false;

    protected $fillable = [
        'component_type_id',
        'componenet_type_name'
    ];
}
