<?php

namespace App\Services;

use App\Jobs\CommentaryJobs\AddCommentaryToElastic;

use App\Eloquent\Contracts\HadithCommentInterface;
use Cviebrock\LaravelElasticsearch\Facade as ElasticSearch;

class HadithCommentService
{

  public function __construct(HadithCommentInterface $repository){
    $this->repository = $repository;
  }

  public function getAll(){
    $comments = $this->repository->all();
    return $comments;
  }

  public function getCommentaryText($id){

      $params = [
        'index' => 'commentary',
        'type' => '_doc',
        'id' => $id,
        '_source' => ['text'],
      ];

      try {
          $results = Elasticsearch::get($params);
          return $results['_source']['text'];

      } catch (\Exception $e) {
          return $e->getMessage();
      }

  }

  public function commentsForHadith($id){
    $comments = $this->repository->commentsForHadith($id);

    return $comments;
  }

  public function addComment($data){

    $text = $data['text'];

    $blurb = strlen($text) > 200 ? substr($text, 0, 200) . '...' : $text;
    
    $comment = $this->repository->addComment([
      'hadith_id' => $data['hadith_id'],
      'commentary_id' => $data['commentary_id'],
      'blurb' => $blurb,
    ]);

    $data['id'] = $comment->id;

    AddCommentaryToElastic::dispatch($data);

    $comment->text = $data['text'];

    return $comment;
  }

  public function updateComment(){
    //TODO
  }
}
