<?php
namespace App\Services;

use App\Jobs\HadithJobs\AddHadithToNeo4j;
use App\Jobs\HadithJobs\AddHadithToElastic;
use App\Jobs\HadithJobs\AddLinkToNeo4j;
use App\Jobs\HadithJobs\LinkHadithInNeo4j;

use App\Events\HadithAdded;

use App\NeoEloquent\Entities\Hadith as NeoHadith;//Not needed?
use App\Elasticsearch\Entities\Hadith as ElasticHadith;

use App\Eloquent\Contracts\HadithInterface;
use App\Eloquent\Contracts\PersonInterface;
use Illuminate\Support\Facades\Storage;

use TSF\Neo4jClient\Facades\Neo4jClient;
use Cviebrock\LaravelElasticsearch\Facade as ElasticSearch; //NO LONGER NEEDED?

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

    return $hadith;
  }


  public function addHadith($data){

    $body = $data['body'];
    $number = $data['number'];
    $chain = $data['chain'];
    $section_id = $data['section_id'];
    $section = $data['section'];
    $book = $data['book'];
    //shorten the body text
    $blurb = strlen($body) > 200 ? substr($body, 0, 200) . '...' : $body;
    //store hadith in mysql
    $hadith = $this->repository->create([
      'number' => $number,
      'section_id' => $section_id,
      'chain' => $chain,
      'blurb' => $blurb,
    ]);

    //get sql id for hadith
    $id = $hadith->id;
    
    //store hadith in neo4j attaching it to the correct section
    $neo_hadith = Neo4jClient::run("
    MATCH (a:Section {sql_id: {$section_id} }) WITH a 
    MERGE (b:Hadith {sql_id: {$id}, number: {$number}, chain: '{$chain}', blurb: '{$blurb}', book: '{$book}', section: '{$section}' })
    MERGE (a)-[:CONTAINS]->(b)");

    //store hadith body in filesystem
    $path = 'hadith/' . $id . '.txt';
    Storage::put($path, $body, 'private');

    $hadith->body = $body;

    //AddHadithToNeo4j::dispatch($data);


    $elastic_hadith = new ElasticHadith;
    $elastic_hadith->create($id, $data);
      
  //  AddHadithToElastic::dispatch($id, $data);

    $event = new HadithAdded();
    $event->hadith($hadith);

    broadcast($event); //TODO

    return $hadith;
  }

  public function updateHadith($data){

    $id = $data['id'];
    $body = $data['body'];
    $chain = $data['chain'];

    $blurb = strlen($body) > 200 ? substr($body, 0, 200) . '...' : $body;
    $data['blurb'] = $blurb;

    $hadith = $this->repository->updateHadith($data); //make this into queued job?

    $neo_query = "MATCH(hadith:Hadith {sql_id: {$id} })
    SET hadith.chain = '{$chain}', hadith.blurb = '{$blurb}'"; //make this into queued job?

    $neo_hadith = Neo4jClient::run($neo_query);

    $path = 'hadith/' . $id . '.txt';
    Storage::delete($path);
    Storage::put($path, $body, 'private'); //make this into queued job?

    $elastic_hadith = new ElasticHadith;
    $elastic_data = ['body' => $body, 'chain' => $chain]; 
    $elastic_hadith->update($id, $elastic_data);

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

    //$tx = Neo4jClient::transaction();

    $neo_query = "MATCH(narrator: Narrator { sql_id: {$narrator_id}})
    MATCH(hadith: Hadith { sql_id : {$hadith_id}})
    WITH hadith, narrator
    MERGE(link: Link { position : {$position}, hadith_id : {$hadith_id}})
    MERGE(narrator)-[:OF]->(link)-[:BELONGS_TO]->(hadith)";

    //$tx->push($neo_query);

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
    $first_hadith = $data['hadith_1_id'];
    $second_hadith = $data['hadith_2_id'];
    if($first_hadith == $second_hadith){
      return null;
    }

    $neo_query = "MATCH(first_hadith:Hadith {sql_id: {$first_hadith} })
    MATCH(second_hadith:Hadith {sql_id: {$second_hadith} })
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
        $chain = $this->repository->getChain($id);
   
          $related_hadiths[] = ['id' => $id, 'body' => $content, 'book' => $book, 'section' => $section, 'position' => $position, 'links' => $chain];
      } catch (\Exception $e) {
        return $e->getMessage();
      }

    }

    return $related_hadiths;
  }

  public function getSuggestedHadith($id){

    $id = (int)$id;

    $query = "MATCH(a:Hadith {sql_id: {$id} })-[:RELATED_TO]-(m)-[:RELATED_TO]-(n) WHERE NOT (a)-[:RELATED_TO]-(n) RETURN n";
    $suggested_hadiths = [];
    $records = Neo4jClient::run($query)->getRecords();

    foreach($records as $record){
      $record = $record->get('n');
      $id = $record->value('sql_id');
      $book = $record->value('book');
      $section = $record->value('section');
      $position = $record->value('number');

      try {
        $path = 'hadith/' . $id . '.txt';
        $content = Storage::get($path);
     
          $suggested_hadiths[] = ['id' => $id, 'body' => $content, 'book' => $book, 'section' => $section, 'position' => $position];
      } catch (\Exception $e) {
        return $e->getMessage();
      }


    }

    return $suggested_hadiths;
  }
}
