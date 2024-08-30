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
class Event extends Model implements Transformable
{
    use TransformableTrait;
    // use SoftDeletes;

    public $incrementing = true;

    protected $fillable = [
        'event_uid',
        'service_id',
        'user_uid',
        'res_service_id',
        'response_uid',
        'ts1',
        'ts2',
        'ts3',
        'ts4',
        'ip',
        'username',
    ];

    protected $table = 'public.event';
    protected $connection = 'pgsql_billiton';

    
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'service_id');
    } 

    public function user()
    {
        return $this->belongsTo(UsersBilliton::class, 'user_uid', 'user_uid');
    }
    
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'event_uid', 'event_uid');
    }   

}
