<?php

namespace App\Eloquent\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Eloquent\Contracts\PersonInterface;
use App\Eloquent\Entities\Commentator;
//use App\Validators\Eloquent\AuthorValidator;

/**
 * Class AuthorRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class CommentatorRepository extends BaseRepository implements PersonInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Commentator::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
