<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class TransactionLog extends Model
{

    protected $connection = 'pgsql_billiton';
    //
    protected $fillable = [
        'stan',
        'proc_code',
        'responsecode',
        'tx_mti' ,
        'rp_mti' ,
        'tx_amount',
        'tx_time',
        'transaction_id',
        'additional_data'
    ];

    
    protected $table = 'channel.transaction_log';
}
