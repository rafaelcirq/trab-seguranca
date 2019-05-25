<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class PessoasHash.
 *
 * @package namespace App\Entities;
 */
class PessoasHash extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'pessoas_hash';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nome', 'cidade'];

}
