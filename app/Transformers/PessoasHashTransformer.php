<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\PessoasHash;

/**
 * Class PessoasHashTransformer.
 *
 * @package namespace App\Transformers;
 */
class PessoasHashTransformer extends TransformerAbstract
{
    /**
     * Transform the PessoasHash entity.
     *
     * @param \App\Entities\PessoasHash $model
     *
     * @return array
     */
    public function transform(PessoasHash $model)
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
