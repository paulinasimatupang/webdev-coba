<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Merchants.
 *
 * @package namespace App\Entities;
 */
class Merchant extends Model implements Transformable
{
    use TransformableTrait;
    use SoftDeletes;

    public $incrementing = true;

    protected $fillable = [
        'id',
        'name',
        'no',
        'code',
        'address',
        'phone',
        'email',
        'balance',
        'avatar',
        'status',
        'user_id',
        'terminal_id',
        'city',
        'screen_id',
        'mid',
        'status_agen',
        'active_at',
        'resign_at',
        'branchid',
        'no_cif',
        'kode_produk',
        'no_registrasi',
        'file_ktp',
        'file_kk',
        'file_npwp'
    ];

    protected $table = 'merchants';
    protected $connection = 'pgsql';

    public function terminal()
    {
        return $this->hasMany(Terminal::class,'mid','merchant_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class,'no','account_number');
    }

}
