<?php

namespace App\Entities;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Webpatser\Uuid\Uuid;
use DateTimeZone;
use DateTime;
use Illuminate\Database\Eloquent\Model;

class UsersBilliton extends Model
{
    //
    protected $connection = 'pgsql_billiton';
    protected $primaryKey = 'user_uid';
    public $timestamps = false;
    //
    protected $fillable = [
        'user_uid',
        'user_status_uid',
        'user_type_uid',
        'username',
        'password',
        'password_retry',
        'msisdn',
        'card_no',
        'imei',
        'bahasa',
        'version',
        'brand',
        'model',
        'os',
        'os_ver',
        'reg_date',
        'account_name',
        'imsi',
        'app_ver',
        'active_via',
        'need_approval',
        'user_status_old',
        'batch_no',
        'pin',
        'pin_retry'
    ];
    
    protected $table = 'public.users';


    public function events()
    {
        return $this->hasMany(Event::class, 'user_uid', 'user_uid');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'user_uid', 'user_uid');
    }

    public function merchants()
    {
        return $this->hasMany(Merchant::class, 'user_id', 'user_uid');
    }
}