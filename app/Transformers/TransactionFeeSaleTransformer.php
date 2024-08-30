<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\TransactionBJB;
use App\Entities\TransactionFeeSale;

/**
 * Class TransactionBJBTransformer.
 *
 * @package namespace App\Transformers;
 */
class TransactionFeeSaleTransformer extends TransformerAbstract
{
    /**
     * Transform the TransactionBJB entity.
     *
     * @param \App\Entities\TransactionBJB $model
     *
     * @return array
     */
    public function transform(TransactionFeeSale $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
