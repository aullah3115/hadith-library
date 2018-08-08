<?php

namespace App\Services;

use App\Jobs\NarratorJobs\AddNarratorToNeo4j;
use App\Jobs\NarratorJobs\AddNarratorToElastic;

use App\Eloquent\Contracts\PersonInterface;
use App\NeoEloquent\Entities\Narrator as NeoNarrator;

use TSF\Neo4jClient\Facades\Neo4jClient;
use Cviebrock\LaravelElasticsearch\Facade as ElasticSearch;
use Illuminate\Support\Facades\Storage;

class NarratorService
{

  public function __construct(PersonInterface $repository){
    $this->repository = $repository;
  }

  public function getAll(){
    $narrators = $this->repository->all();
    return $narrators;
  }

  public function getById($id){
    $narrator = $this->repository->find($id);
    return $narrator;
  }

  public function getTeachers($id){

    $query = "MATCH (narrator:Narrator{sql_id:{$id}})-[:OF]->(a)-[:FROM]->(b)<-[:OF]-(teacher) RETURN DISTINCT teacher";

    $records = Neo4jClient::run($query)->getRecords();

    $teachers = [];

    foreach($records as $record){
      $record = $record->get('teacher');
      $teachers[] = [
        'id' => $record->value('sql_id'),
        'used_name' => $record->value('used_name')
      ];
    }

    return $teachers;
  }

  public function getStudents($id){

    $query = "MATCH (narrator:Narrator{sql_id:{$id}})-[:OF]->(a)<-[:FROM]-(b)<-[:OF]-(student) RETURN DISTINCT student";

    $records = Neo4jClient::run($query)->getRecords();

    $students = [];

    foreach($records as $record){
      $record = $record->get('student');
      $students[] = [
        'id' => $record->value('sql_id'),
        'used_name' => $record->value('used_name')
      ];
    }

    return $students;
  }

  public function getNarrations($data){
    $query =  "MATCH (student:Narrator{sql_id:{$data['student_id']}})-[:OF]->(a)-[:FROM]->(b)<-[:OF]-(teacher:Narrator{sql_id:{$data['teacher_id']}})
              MATCH (a)-[:BELONGS_TO]->(hadith: Hadith)<-[:BELONGS_TO]-(b)
              RETURN DISTINCT hadith";

    $records = Neo4jClient::run($query)->getRecords();

    $narrations = [];

    foreach($records as $record){
      $record = $record->get('hadith');
      $id = $record->value('sql_id');
      $path = 'hadith/' . $id . '.txt';
      $body = Storage::get($path);

      $narrations[] = [
        'id' => $id,
        'blurb' => $record->value('blurb'),
        'book' => $record->value('book'),
        'section' => $record->value('section'),
        'position' => $record->value('number'),
        'body' => $body,
      ];
    }

    return $narrations;
  }

    public function getAllNarrations($id){
      $query = "MATCH(narrator:Narrator{sql_id: {$id}})-[:OF]->(a)-[:BELONGS_TO]->(hadith) RETURN DISTINCT hadith";

      $records = Neo4jClient::run($query)->getRecords();

      $narrations = [];

      foreach($records as $record){
        $record = $record->get('hadith');
        $id = $record->value('sql_id');
        $path = 'hadith/' . $id . '.txt';
        $body = Storage::get($path);

        $narrations[] = [
          'id' => $id,
          'blurb' => $record->value('blurb'),
          'book' => $record->value('book'),
          'body' => $body,
          'section' => $record->value('section'),
          // TODO add section
        ];
      }

      return $narrations;
    }

  public function addNarrator($data){

    $narrator = $this->repository->create($data);
    $id = $narrator->id;

    
    //AddNarratorToElastic::dispatch($data, $id);

    

    //AddNarratorToNeo4j::dispatch($data);
    $elastic_data = [
      'body' => $data,
      'index' => 'narrator',
      'type' => '_doc',
      'id' => $id,
    ];

    try {
      $exists = ElasticSearch::indices()->exists(['index' => 'narrator']);
      // if hadith index doesn't exist create new index
      if(!$exists){
        $params = [
          'index' => 'narrator',
          'body' => [
            'mappings' => [
              '_doc' => [
                'properties' => [
                  'name' => [
                    'type' => 'text',
                    'analyzer' => 'arabic',
                  ],
                  'kunyah' => [
                    'type' => 'text',
                    'analyzer' => 'arabic',
                  ],
                  'used_name' => [
                    'type' => 'text',
                    'analyzer' => 'arabic',
                  ],
                  'laqab' => [
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

      $results = ElasticSearch::index($elastic_data);
    } catch (\Exception $e) {
      
    }
    $data['sql_id'] = $id;

    $neo_narrator = NeoNarrator::create($data);

    return $narrator;
  }

  public function updateAuthor(){
    //TODO
  }
}
