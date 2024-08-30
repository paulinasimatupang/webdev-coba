<?php

namespace App\Entities;

use Auth;
use Illuminate\Database\Eloquent\Model;
use App\Presenters\GroupSchemaPresenter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class GroupSchema.
 *
 * @package namespace App\Entities;
 */
class GroupSchema extends Model implements Transformable
{
    use TransformableTrait;
    use SoftDeletes;

    protected $presenter = GroupSchemaPresenter::class;
    public $incrementing = true;

    protected $fillable = [
        'id',
        'group_id',
        'schema_id',
        'share',
        'is_shareable'
    ];

    protected $table = 'group_schemas';

}
