<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Group.
 *
 * @package namespace App\Entities;
 */
class EventBilliton extends Model implements Transformable
{
    use TransformableTrait;
    use SoftDeletes;

    public $incrementing = true;

    protected $fillable = [
        'event_uid',
        'service_id',
        'user_uid',
        'res_service_id',
        'response_uid',
        //harus bikin buat responsecode
        'ts1',
        'ts2',
        'ts3',
        'ts4',
        'ip',
        'username'
    ];

    protected $table = 'event';
    
    // public function transactions()
    // {
    //     return $this->hasMany(Transaction::class, 'event_uid');
    // }

    //ada relasi sama tabel response code 
    //ada relasi sama user billiton yg mengatur user_uid
}
