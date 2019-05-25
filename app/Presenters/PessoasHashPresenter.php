<?php

namespace App\Presenters;

use App\Transformers\PessoasHashTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class PessoasHashPresenter.
 *
 * @package namespace App\Presenters;
 */
class PessoasHashPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new PessoasHashTransformer();
    }
}
