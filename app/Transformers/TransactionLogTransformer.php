<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\TransactionBJB;
use App\Entities\TransactionFeeLakupandai;
use App\Entities\TransactionFeeSale;
use App\Entities\TransactionLog;

/**
 * Class TransactionBJBTransformer.
 *
 * @package namespace App\Transformers;
 */
class TransactionLogTransformer extends TransformerAbstract
{
    /**
     * Transform the TransactionBJB entity.
     *
     * @param \App\Entities\TransactionLog $model
     *
     * @return array
     */
    public function transform(TransactionLog $model)
    {
        return [
            'stan'         => $model->stan,
            'additional_data'         => $model->additional_data,

            /* place your other model properties here */

            'tx_time' => $model->created_at
        ];
    }
}
