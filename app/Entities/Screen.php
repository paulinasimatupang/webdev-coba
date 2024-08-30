<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class TerminalType.
 *
 * @package namespace App\Entities;
 */
class Screen extends Model implements Transformable
{
    use TransformableTrait;
    protected $connection = 'pgsql_billiton';
    protected $table = 'screen';
    protected $primaryKey = 'screen_id';
    public $incrementing = false;
    public $timestamps = false;


    protected $fillable = [
        'screen_id',
        'screen_type_id',
        'screen_title',
        'version',
        'action_url',
        'screen_title_en',
    ];
    
    public function screenType()
    {
        return $this->belongsTo(ScreenType::class, 'screen_type_id', 'screen_type_id');
    }    
}
