<?php

namespace App\Presenters;

use App\Transformers\TransactionFeeLakupandaiTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class TransactionBJBPresenter.
 *
 * @package namespace App\Presenters;
 */
class TransactionFeeLakupandaiPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new TransactionFeeLakupandaiTransformer();
    }
}
