<?php

namespace App\Eloquent\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Eloquent\Contracts\HadithCommentInterface;
use App\Eloquent\Entities\HadithComment;
//use App\Validators\Eloquent\AuthorValidator;

/**
 * Class AuthorRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class HadithCommentRepository extends BaseRepository implements HadithCommentInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return HadithComment::class;
    }

    public function commentsForHadith($id){
      $comments = $this->model->where('hadith_id', $id)->with('commentary')->get();
      return $comments;
    }

    public function relatedComments($ids){
        $comments = $this->model->wherein('hadith_id', $ids)->with(['commentary', 'hadith.section.book'])->get();
        return $comments;
      }

    public function addComment($data){
      $comment = $this->model->create($data);
      $comment->commentary = $comment->load('commentary');

      return $comment;
    }
    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
