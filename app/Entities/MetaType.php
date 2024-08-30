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
class MetaType extends Model implements Transformable
{
    use TransformableTrait;

    public $incrementing = true;

    protected $fillable = [
        'meta_type_id',
        'meta_type_name',
        'meta_format'
    ];

    protected $connection = 'pgsql_billiton';
    protected $table = 'reff_meta_type';
}
