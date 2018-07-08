<?php
namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Cviebrock\LaravelElasticsearch\Facade as ElasticSearch;

class SearchService
{

  public function __construct(){
  //  $this->repository = $repository;
  }

  public function search($data){

    $index = implode(',', $data['index']);
    $query = $data['query'];

    $params = [
    'index' => $index,
    'type' => '_doc',
    'body' => [
        'query' => [
            'multi_match' => [
                'query' => $query,
                  ]
              ]
          ]
      ];

    $results = Elasticsearch::search($params);
    return $results['hits']['hits'];
  }


}
