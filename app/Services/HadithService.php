<?php
namespace App\Services;

use App\Jobs\HadithJobs\AddHadithToNeo4j;
use App\Jobs\HadithJobs\AddHadithToElastic;
use App\Jobs\HadithJobs\AddLinkToNeo4j;

use App\Events\HadithAdded;

use App\Eloquent\Contracts\HadithInterface;
use App\Eloquent\Contracts\PersonInterface;
use Illuminate\Support\Facades\Storage;

use TSF\Neo4jClient\Facades\Neo4jClient;
use Cviebrock\LaravelElasticsearch\Facade as ElasticSearch;

class HadithService
{
  public function __construct(HadithInterface $repository, PersonInterface $narrator_repo){
    $this->repository = $repository;
    $this->narrator_repo = $narrator_repo;
  }

  public function getById($id){
    $hadith = $this->repository->getById($id);

    $params = [
      'index' => 'hadith',
      'type' => '_doc',
      'id' => $id,
      '_source' => ['body'],
    ];

    try {
        $results = Elasticsearch::get($params);
        $hadith->body =  $results['_source']['body'];

    } catch (\Exception $e) {
        return $e->getMessage();
    }


    return $hadith;
  }


  public function addHadith($data){

    $body = $data['body'];

    $data['blurb'] = strlen($body) > 200 ? substr($body, 0, 200) . '...' : $body;

    $hadith = $this->repository->create([
      'number' => $data['number'],
      'section_id' => $data['section_id'],
      'chain' => $data['chain'],
      'blurb' => $data['blurb'],
    ]);


    $data['id'] = $hadith->id;

    AddHadithToNeo4j::dispatch($data);
    AddHadithToElastic::dispatch($data);

    $hadith->body = $body;

    event(new HadithAdded);

    return $hadith;
  }

  public function getChain($hadith_id){
    $chain = $this->repository->getChain($hadith_id);
    return $chain;
  }

  public function addLink($data){
    $position = $data['position'];
    $hadith_id = (int)$data['hadith_id'];

    $narrator = $this->narrator_repo->find($data['narrator_id']);
    $data['narrator_id'] = (int)$narrator->id;

    $link = $this->repository->addLink($data);

    AddLinkToNeo4j::dispatch($data);

    return $link;
  }

  public function linkHadith($data){
    if($data['hadith_1_id'] == $data['hadith_2_id']){
      return null;
    }
    $linked_hadith = Neo4jClient::run(
      "MATCH(a:Hadith {sql_id: {$data['hadith_1_id']} })
      MATCH(m:Hadith {sql_id: {$data['hadith_2_id']} })
      MERGE(a)-[:RELATED_TO]->(m)
      RETURN m"
    );
    // TODO This return value will not work. Needs changing

    return $linked_hadith;
  }

  public function getLinkedHadith($id){

    $id = (int)$id;

    $query = "MATCH(a:Hadith {sql_id: {$id} })-[:RELATED_TO]-(m) RETURN m";
    $related_hadiths = [];
    $records = Neo4jClient::run($query)->getRecords();

    foreach($records as $record){
      $record = $record->get('m');
      $id = $record->value('sql_id');

      try {
        $params = [
        'index' => 'hadith',
        'type' => '_doc',
        'id' => $id,
        '_source' => ['body'],
          ];

          $results = Elasticsearch::get($params);
          $content = $results['_source']['body'];

      } catch (\Exception $e) {

      }
      $related_hadiths[] = ['id' => $id, 'body' => $content];

    }

    return $related_hadiths;
  }
}
