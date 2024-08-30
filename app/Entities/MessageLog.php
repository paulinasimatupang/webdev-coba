<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class MessageLog extends Model
{
    protected $connection = 'pgsql_billiton';
    protected $primaryKey = 'log_id';
    
    protected $quotes = '"';
    //
    protected $fillable = [
        'message_id',
        'terminal_id',
        'service_id',
        'request_time',
        'reply_time',
        'log_id',
        'message_status',
        'request_message',
        'response_message'

    ];

    protected $table = "messagelog";
}
