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
class Transaction extends Model implements Transformable
{
    use TransformableTrait;

    public $incrementing = true;

    protected $fillable = [
        'transaction_code',
        'service_id',
        'event_uid',
        'transaction_status_id',
        'transaction_time',
        'amount',
        'fee',
        'account_number',
        'no_resi',
        'user_uid',
        'card_no',
        'trace_no',
        'batch_no',
        'appr_code',
    ];

    protected $primaryKey = 'transaction_id';
    protected $table = 'public.transaction';
    protected $connection = 'pgsql_billiton';
    public $timestamps = false;

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_uid', 'event_uid');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'service_id');
    }

    public function transactionStatus()
    {
        return $this->belongsTo(TransactionStatus::class, 'transaction_status_id', 'transaction_status_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_uid', 'id');
    }

    public function merchant()
    {
        return $this->belongsTo(Merchant::class, 'account_number', 'no');
    }
}
