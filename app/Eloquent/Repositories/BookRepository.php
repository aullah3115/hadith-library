<?php

namespace App\Eloquent\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Eloquent\Contracts\BookInterface;
use App\Eloquent\Entities\Book;
//use App\Validators\Eloquent\BookValidator;

/**
 * Class BookRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class BookRepository extends BaseRepository implements BookInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Book::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
