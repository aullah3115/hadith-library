<?php

namespace App\Services;

use App\Jobs\CommentaryJobs\AddCommentaryToElastic;

use App\Eloquent\Contracts\HadithCommentInterface;
use Cviebrock\LaravelElasticsearch\Facade as ElasticSearch;
use Illuminate\Support\Facades\Storage;

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

      $path =  'commentary/' . $id . ".txt";
      return Storage::get($path);
    /*
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
      */
  }

  public function commentsForHadith($id){
    $comments = $this->repository->commentsForHadith($id);

    return $comments;
  }

  public function relatedComments($data){
    $comments = $this->repository->relatedComments($data);

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

    $id = $comment->id;
    
    

    try {
      $exists = ElasticSearch::indices()->exists(['index' => 'commentary']);
      // if hadith index doesn't exist create new index
      if(!$exists){
        $params = [
          'index' => 'commentary',
          'body' => [
            'mappings' => [
              '_doc' => [
                'properties' => [
                  'text' => [
                    'type' => 'text',
                    'analyzer' => 'arabic',
                  ],
                  'book' => [
                    'type' => 'text',
                    'analyzer' => 'arabic',
                  ],
                ]
              ]
            ]
          ]
      ];

      $response = ElasticSearch::indices()->create($params);
      }
      $elastic_data = [
        'body' => [
            'text' => $data['text'],
            'book' => $data['book'],
        ],
        'index' => 'commentary',
        'type' => '_doc',
        'id' => $id,
        ];
      $results = ElasticSearch::index($elastic_data);
    } catch (\Exception $e) {

    }

    $path =  'commentary/' . $id . ".txt";
    Storage::put($path, $text, 'private');

    //AddCommentaryToElastic::dispatch($data);

    $comment->text = $text;

    return $comment;
  }

  public function updateComment(){
    //TODO
  }
}
