<?php

namespace App\Entities;

use App\Presenters\TransactionFeeSalePresenter;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

/**
 * Class TransactionBJB.
 *
 * @package namespace App\Entities;
 */
class TransactionFeeSale extends Model
{
//    use TransformableTrait;
//    use SoftDeletes;

    protected $presenter = TransactionFeeSalePresenter::class;
//    public $incrementing = true;
    protected $connection = 'pgsql_billiton';


    // protected $fillable = [
    //     'id',
    //     'transaction_name',
    //     'transaction_code',
    //     'product_name',
    //     'nominal',
    //     'fee',
    //     'total'
    // ];

    protected $table = 'sale_ppob_view';
    //protected $table = 'reff_pmt_transactions';

    // public function productTransaction()
    // {
    //     return $this->hasOne(Transaction::class,'stan','stan');
    // }

}
