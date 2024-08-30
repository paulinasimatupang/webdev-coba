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

class ComponentContentType extends Model implements Transformable
{
    use TransformableTrait;
    protected $connection = 'pgsql_billiton';
    protected $table = 'reff_comp_content_type';
    protected $primaryKey = 'comp_content_type';
    public $incrementing = false;
    protected $fillable = [
        'comp_content_type', 
        'comp_content_type_name'
    ]; 
}

