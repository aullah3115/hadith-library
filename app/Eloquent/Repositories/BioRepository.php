<?php

namespace App\Eloquent\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Eloquent\Contracts\BioInterface;
use App\Eloquent\Entities\Bio;
//use App\Validators\Eloquent\BookValidator;

/**
 * Class BookRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class BioRepository extends BaseRepository implements BioInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Bio::class;
    }

    public function addBio($data){
      $bio = $this->model->create($data);
      $bio->source = $bio->load('source');

      return $bio;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
