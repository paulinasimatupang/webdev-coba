<?php

namespace App\Presenters;

use App\Transformers\TransactionFeeLakupandaiTransformer;
use App\Transformers\TransactionLogTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class TransactionBJBPresenter.
 *
 * @package namespace App\Presenters;
 */
class TransactionLogPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new TransactionLogTransformer();
    }
}
