<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class TransactionSaleBJB extends Model
{
    protected $presenter = TransactionBJBPresenter::class;
    protected $connection = 'pgsql_billiton';

    protected $table = 'all_trx_view';
}
