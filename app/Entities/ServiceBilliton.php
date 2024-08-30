<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Services.
 *
 * @package namespace App\Entities;
 */
class ServiceBilliton extends Model implements Transformable
{
    use TransformableTrait;
    use SoftDeletes;

    public $incrementing = true;

    protected $fillable = [
        'service_id',
        'service_name',
        'is_transactional',
        'screen_response',
        'screen_start',
        'is_to_core',
        'service_class',
        'param1',
        'param2',
        'trx_tbl'
    ];

    protected $table = 'service';

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'service_id');
    }
}
