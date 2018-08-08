<?php
namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Cviebrock\LaravelElasticsearch\Facade as ElasticSearch;
use App\Elasticsearch\Entities\Search;

class SearchService
{

  public function __construct(){
  //  $this->repository = $repository;
  }

  public function search($data){

    $elastic_search = new Search;
    $results = $elastic_search->search($data['index'], $data['query']);
    return $results;
  }


}
