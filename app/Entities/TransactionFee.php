<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Transactions.
 *
 * @package namespace App\Entities;
 */
class TransactionFee extends Model implements Transformable
{
    use TransformableTrait;

    public $incrementing = true;

    protected $fillable = [
        'transaction_code',
        'penerima',
        'fee'
    ];

    protected $table = 'public.transaction_fee';
    protected $connection = 'pgsql_billiton';
    public $timestamps = false;
}
