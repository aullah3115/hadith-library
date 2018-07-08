<?php

namespace App\Eloquent\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Eloquent\Contracts\HadithTranslationInterface;
use App\Eloquent\Entities\HadithTranslation;
//use App\Validators\Eloquent\AuthorValidator;

/**
 * Class AuthorRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class HadithTranslationRepository extends BaseRepository implements HadithTranslationInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return HadithTranslation::class;
    }

    public function translationsForHadith($id){
      $translations = $this->model->where('hadith_id', $id)->with('language')->get();
      return $translations;
    }

    public function addTranslation($data){
      $translation = $this->model->create($data);
      $translation->language = $translation->load('language');

      return $translation;
    }
    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
