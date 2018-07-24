<?php

namespace App\Eloquent\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Eloquent\Contracts\SectionInterface;
use App\Eloquent\Entities\Section;
//use App\Validators\Eloquent\BookValidator;

/**
 * Class BookRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class SectionRepository extends BaseRepository implements SectionInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Section::class;
    }

    public function getHadith($id){
      $parent = $this->model->find($id);
      $hadiths = $parent->hadith;

      return $hadiths;
    }

    public function createSection($data){
      if(!$data['book_id']){
        $book_id = $this->model->find($data['parent_id'])->book_id;
        $data['book_id'] = $book_id;
      }

      $section = $this->model->create($data);
      return $section;

    }

    public function updateSection($data){
      
      
      $section = $this->model->find($data['section_id']);
     
      $section->name = $data['name'];
      $section->has_section = $data['has_section'];
      $section->has_hadith = $data['has_hadith'];

      $section->save();
      return $section;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
