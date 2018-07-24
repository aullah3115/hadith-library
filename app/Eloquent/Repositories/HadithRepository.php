<?php

namespace App\Eloquent\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Eloquent\Contracts\HadithInterface;
use App\Eloquent\Entities\Hadith;

//use App\Validators\Eloquent\AuthorValidator;

/**
 * Class AuthorRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class HadithRepository extends BaseRepository implements HadithInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Hadith::class;
    }

    public function updateHadith($data){
      $hadith = $this->model->find($data['id']);

      $hadith->chain = $data['chain'];
      $hadith->blurb = $data['blurb'];

      $hadith->save();

      $hadith->section = $hadith->load('section.book');

      return $hadith;
    }

    public function getById($id){
      $hadith = $this->model->find($id);
      $hadith->section = $hadith->load('section.book');

      return $hadith;
    }

    public function getChain($id){
      $hadith = $this->model->find($id);
      $chain = $hadith->narrators()->get();

      return $chain;
    }

    public function addLink($data){
      $hadith = $this->model->find($data['hadith_id']);
      $hadith->narrators()->attach($data['narrator_id'], ['position' => $data['position']]);
      $link = $hadith->narrators()->where('narrator_id', $data['narrator_id'])->get();

      return $link;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
