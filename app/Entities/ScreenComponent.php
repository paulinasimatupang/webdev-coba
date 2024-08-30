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
class ScreenComponent extends Model implements Transformable
{
    use TransformableTrait;
    protected $connection = 'pgsql_billiton';
    protected $table = 'screen_component';
    protected $primaryKey = 'screen_id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'screen_id',
        'comp_id',
        'sequence'
    ];
    
    public function screen()
    {
        return $this->belongsTo(Screen::class, 'screen_id', 'screen_id');
    }    

    public function component()
    {
        return $this->belongsTo(Component::class, 'comp_id', 'comp_id');
    }   
}
