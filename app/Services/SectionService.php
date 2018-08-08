<?php
namespace App\Services;

use App\Eloquent\Contracts\SectionInterface;
use Illuminate\Support\Facades\Storage;
use TSF\Neo4jClient\Facades\Neo4jClient;

class SectionService
{

  public function __construct(SectionInterface $repository){
    $this->repository = $repository;
  }

  public function getAll($book_id, $parent_id){

    $data = [
      'parent_id' => $parent_id,
    ];

    if ($book_id != 'null'){
      $data['book_id'] = $book_id;
    }

    $sections = $this->repository->findWhere($data);
    return $sections;
  }

  public function getByID($id){
    $section = $this->repository->find($id);
    $book = $section->book;

    $response = ['book' => $book, 'parent' => $section];
    return $response;
  }

  public function getHadith($id){
    $hadiths = $this->repository->getHadith($id);
    /*
    foreach ($hadiths as $hadith) {
      $path = 'hadith/' . $hadith->id . '.txt';
      $content = Storage::get($path);
      $hadith->body = $content;
    }
*/
    return $hadiths;
  }

  public function addSection($data){

    $section = $this->repository->createSection($data);
    $id = $section->id;
    $name = $data['name'];
    $book_id = $data['book_id'];
    $parent_id = $data['parent_id'];
    if($book_id){
      $neo_section = Neo4jClient::run(
        "MATCH (a:Book {sql_id: {$book_id} }) 
        WITH a 
        MERGE (b:Section {name: '{$name}', sql_id: {$id} }) 
        MERGE (a)-[:CONTAINS]->(b)");
    } 

    if($parent_id){
      $neo_section = Neo4jClient::run(
        "MATCH (a:Section {sql_id: {$parent_id} }) 
        WITH a 
        MERGE (b:Section {name: '{$name}', sql_id: {$id} }) 
        MERGE (a)-[:CONTAINS]->(b)");
    } 
    

    return $section;
  }

  public function updateSection($data){
    $section = $this->repository->updateSection($data);
    $old_name = $data['old_name'];
    $name = $data['name'];

    $query = "MATCH (hadith:Hadith {section: {$old_name} }) SET hadith.section = {$name}";

    Neo4jClient::run($query);

    $update = [
      'index'     => 'hadith',
      'type'      => '_doc',
      'conflicts' => 'proceed',
      'body' => [
          'query' => [
              'query_string' => [
                'fields' => ['section'],
                'query' => "\"{$data['old_name']}\"",
              ]
          ],

          'script' => [
              'lang' => 'painless',
              'inline' => 'ctx._source.section = params.section',
                  'params' => [
                      'section' => $data['name'],
                  ]
              ]

      ]
  ]; // TODO make into job
    $results = ElasticSearch::updateByQuery($update);

    return $section;
  }
}
