<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class ReportMiniBanking extends Model
{
    protected $connection = 'pgsql_report';
    protected $primaryKey = 'ids';
    //
    protected $fillable = [
        'stan',
        'request_time',
        'tx_time',
        'tid',
        'mid',
        'agent_name',
        'product_name',
        'transaction_name',
        'nominal',
        'fee',
        'agent_fee',
        'bjb_fee',
        'selada_fee',
        'total',
        'billid',
        'proc_code',
        'message_status',
        'rc',
        'status',
        'reversal_stan',
        'reversal_rc',
        'reversal_time',
        'reversal_service_id',
        'host_ref',
        'tx_pan',
        'src_account',
        'dst_account',
        'message_id',
        'created_at',
        'deleted_at',
        'updated_at',
        'buffer',
        'ids'
    ];
    
    protected $table = 'public.report_mini_banking';
}
