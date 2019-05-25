<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PessoasRepository;
use App\Entities\Pessoas;
use App\Validators\PessoasValidator;

/**
 * Class PessoasRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PessoasRepositoryEloquent extends BaseRepository implements PessoasRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Pessoas::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return PessoasValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
