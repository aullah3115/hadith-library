<?php

namespace App\Eloquent\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Eloquent\Contracts\BioBookInterface;
use App\Eloquent\Entities\BioBook;
//use App\Validators\Eloquent\BookValidator;

/**
 * Class BookRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class BioBookRepository extends BaseRepository implements BioBookInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return BioBook::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
