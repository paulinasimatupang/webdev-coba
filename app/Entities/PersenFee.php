<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Support\Str;

/**
 * Class PersenFee.
 *
 * @package namespace App\Entities;
 */
class PersenFee extends Model
{
    protected $connection = 'pgsql_billiton';
    protected $table = 'persen_fee';
    public $incrementing = false;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'penerima',
        'persentase'
    ];
}
