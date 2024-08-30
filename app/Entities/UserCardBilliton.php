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
class UserCardBilliton extends Model implements Transformable
{
    use TransformableTrait;
    use SoftDeletes;

    public $incrementing = true;

    protected $fillable = [
        'username',
        'card_no',
        'card_pin'
    ];

    protected $table = 'user_card';

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'card_no');
    }
}
