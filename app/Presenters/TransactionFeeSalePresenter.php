<?php

namespace App\Presenters;

use App\Transformers\TransactionFeeSaleTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class TransactionBJBPresenter.
 *
 * @package namespace App\Presenters;
 */
class TransactionFeeSalePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new TransactionFeeSaleTransformer();
    }
}
