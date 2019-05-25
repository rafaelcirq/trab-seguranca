<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Pessoas;

/**
 * Class PessoasTransformer.
 *
 * @package namespace App\Transformers;
 */
class PessoasTransformer extends TransformerAbstract
{
    /**
     * Transform the Pessoas entity.
     *
     * @param \App\Entities\Pessoas $model
     *
     * @return array
     */
    public function transform(Pessoas $model)
    {
        return [
            'id'         => (int) $model->id,

            'nome' => $model->nome,
            'cidade' => $model->cidade,

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
