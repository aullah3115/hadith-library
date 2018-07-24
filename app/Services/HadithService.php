<?php
namespace App\Services;

use App\Jobs\HadithJobs\AddHadithToNeo4j;
use App\Jobs\HadithJobs\AddHadithToElastic;
use App\Jobs\HadithJobs\AddLinkToNeo4j;
use App\Jobs\HadithJobs\LinkHadithInNeo4j;

use App\Events\HadithAdded;

use App\NeoEloquent\Entities\Hadith as NeoHadith;

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

    $path = 'hadith/' . $id . '.txt';
    $hadith->body = Storage::get($path);
    /*

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
*/

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

    $neo_hadith = NeoHadith::create([
      'sql_id' => $data['id'],
      'number' => $data['number'],
      'blurb' => $data['blurb'],
      'book' => $data['book'],
      'section' => $data['section'],
    ]); // TODO change to Neo4j client

    //AddHadithToNeo4j::dispatch($data);

    $elastic_data = [
    'body' => [
        'body' => $data['body'],
        'chain' => $data['chain'],
        'book' => $data['book'],
        'section' => $data['section'],
    ],
    'index' => 'hadith',
    'type' => '_doc',
    'id' => $data['id'],
    ];
    try {
      $results = ElasticSearch::index($elastic_data);
    } catch (\Exception $e) {

    }
  //  AddHadithToElastic::dispatch($data);
    $path = 'hadith/' . $data['id'] . '.txt';
    Storage::put($path, $data['body'], 'private');

    $hadith->body = $body;

    //event(new HadithAdded);

    return $hadith;
  }

  public function updateHadith($data){

    $body = $data['body'];

    $data['blurb'] = strlen($body) > 200 ? substr($body, 0, 200) . '...' : $body;

    $hadith = $this->repository->updateHadith($data);

    $id = (int)$data['id'];

    $neo_query = "MATCH(hadith:Hadith {sql_id: {$data['id']} })
    SET hadith.chain = '{$data['chain']}', hadith.blurb = '{$data['blurb']}'";

    $neo_hadith = Neo4jClient::run($neo_query);

    $params = [
      'index' => 'hadith',
      'type' => '_doc',
      'id' => $data['id'],
      'body' => [
          'doc' => [
            'body' => $data['body'],
            'chain' => $data['chain'],
          ]
      ]
  ];
  
    try {
      $response = Elasticsearch::update($params);
    } catch (\Exception $e) {

    }

    $path = 'hadith/' . $data['id'] . '.txt';
    Storage::delete($path);
    Storage::put($path, $data['body'], 'private');

    $hadith->body = $body;

    //event(new HadithAdded);

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

    $position = (int)$data['position'];
    $hadith_id = (int)$data['hadith_id'];
    $narrator_id = (int)$data['narrator_id'];

    $neo_query = "MATCH(narrator: Narrator { sql_id: {$narrator_id}})
    MATCH(hadith: Hadith { sql_id : {$hadith_id}})
    WITH hadith, narrator
    MERGE(link: Link { position : {$position}, hadith_id : {$hadith_id}})
    MERGE(narrator)-[:OF]->(link)-[:BELONGS_TO]->(hadith)";

    Neo4jClient::run($neo_query);

    $prev_pos = $position - 1;

    $neo_query = "MATCH(current_link: Link { position : {$position}, hadith_id : {$hadith_id}})
    MATCH(previous_link: Link { position : {$prev_pos}, hadith_id : {$hadith_id}})
    WITH current_link, previous_link
    MERGE(current_link)-[:FROM]->(previous_link)";

    if($prev_pos > 0){
        Neo4jClient::run($neo_query);
      }

    //AddLinkToNeo4j::dispatch($data);

    return $link;
  }

  public function linkHadith($data){
    if($data['hadith_1_id'] == $data['hadith_2_id']){
      return null;
    }

    $neo_query = "MATCH(first_hadith:Hadith {sql_id: {$data['hadith_1_id']} })
    MATCH(second_hadith:Hadith {sql_id: {$data['hadith_2_id']} })
    WITH first_hadith, second_hadith
    MERGE(first_hadith)-[:RELATED_TO]->(second_hadith)";

    Neo4jClient::run($neo_query);

    //LinkHadithInNeo4j::dispatch($data);

    return;
  }

  public function getLinkedHadith($id){

    $id = (int)$id;

    $query = "MATCH(a:Hadith {sql_id: {$id} })-[:RELATED_TO]-(m) RETURN m";
    $related_hadiths = [];
    $records = Neo4jClient::run($query)->getRecords();

    foreach($records as $record){
      $record = $record->get('m');
      $id = $record->value('sql_id');
      $book = $record->value('book');
      $section = $record->value('section');
      $position = $record->value('number');

      try {

        $path = 'hadith/' . $id . '.txt';
        $content = Storage::get($path);
        /*
        $params = [
        'index' => 'hadith',
        'type' => '_doc',
        'id' => $id,
        '_source' => ['body', 'book'],
          ];

          $results = Elasticsearch::get($params);
          $content = $results['_source']['body'];
          $book = $results['_source']['book'];
          */
          $related_hadiths[] = ['id' => $id, 'body' => $content, 'book' => $book, 'section' => $section, 'position' => $position];
      } catch (\Exception $e) {
        return $e->getMessage();
      }

    }

    return $related_hadiths;
  }

  public function getSuggestedHadith($id){

    $id = (int)$id;

    $query = "MATCH(a:Hadith {sql_id: {$id} })-[:RELATED_TO]-(m)-[:RELATED_TO]-(n) RETURN n";
    $suggested_hadiths = [];
    $records = Neo4jClient::run($query)->getRecords();

    foreach($records as $record){
      $record = $record->get('n');
      $id = $record->value('sql_id');

      try {
        $params = [
        'index' => 'hadith',
        'type' => '_doc',
        'id' => $id,
        '_source' => ['body', 'book'],
          ];

          $results = Elasticsearch::get($params);
          $content = $results['_source']['body'];
          $book = $results['_source']['book'];

          $suggested_hadiths[] = ['id' => $id, 'body' => $content, 'book' => $book];
      } catch (\Exception $e) {
        return $e->getMessage();
      }


    }

    return $suggested_hadiths;
  }
}
