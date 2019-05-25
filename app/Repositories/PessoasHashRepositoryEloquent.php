<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PessoasHashRepository;
use App\Entities\PessoasHash;
use App\Validators\PessoasHashValidator;

/**
 * Class PessoasHashRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PessoasHashRepositoryEloquent extends BaseRepository implements PessoasHashRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PessoasHash::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return PessoasHashValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
