<?php

namespace App\Presenters;

use App\Transformers\PessoasTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class PessoasPresenter.
 *
 * @package namespace App\Presenters;
 */
class PessoasPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new PessoasTransformer();
    }
}
