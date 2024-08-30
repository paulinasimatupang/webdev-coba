<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Transactions.
 *
 * @package namespace App\Entities;
 */
class ServiceMeta extends Model implements Transformable
{
    use TransformableTrait;
    protected $connection = 'pgsql_billiton';
    protected $table = 'service_meta';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'meta_id',
        'service_id',
        'seq',
        'meta_type_id',
        'meta_default',
        'influx'
    ];
    
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'service_id');
    }

    public function metaType()
    {
        return $this->belongsTo(MetaType::class, 'meta_type_id', 'meta_type_id');
    }   
}
