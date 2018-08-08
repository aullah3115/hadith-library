<?php

namespace App\Elasticsearch\Entities;

use Cviebrock\LaravelElasticsearch\Facade as ElasticSearch;
use App\Elasticsearch\Entities\Hadith;

class Hadith 
{

    protected $index_name = "hadith";
    protected $client;
    protected $shards = 5;
    protected $replicas = 1;
    protected $properties = [
        'body' => [
          'type' => 'text',
          'analyzer' => 'arabic',
        ],
        'chain' => [
          'type' => 'text',
          'analyzer' => 'arabic',
        ],
        'book' => [
          'type' => 'text',
          'analyzer' => 'arabic',
        ],
        'section' => [
          'type' => 'text',
          'analyzer' => 'arabic',
        ],
    ];

    public function __construct(){
        $this->client = new ElasticSearch; 
        if(!$this->indexExists()){
            $this->createIndex();
        }
    }

    public function indexExists(){
        return $this->client::indices()->exists(['index' => $this->index_name]);
    }

    public function createIndex(){

        $params = [
            'index' => $this->index_name,
            'body' => [
                'settings' => [
                    'number_of_shards' => $this->shards,
                    'number_of_replicas' => $this->replicas,
                ],
                'mappings' => [
                    '_doc' => [
                    'properties' => $this->properties,
                ]
              ]
            ]
        ];

        $this->client::indices()->create($params);

    }

    public function deleteIndex(){
        $params = ['index' => $this->index_name];
        $this->$client::indices()->delete($params);
    }

    public function create($id, $data){
        $elastic_data = [
            'body' => $data,
            'index' => $this->index_name,
            'type' => '_doc',
            'id' => $id,
            ];
        $this->client::index($elastic_data);
    }

    public function update($id, $data){
        $params = [
            'index' => 'hadith',
            'type' => '_doc',
            'id' => $id,
            'body' => [
                'doc' => $data,
            ]
        ];
        
          
        $response = $this->client::update($params);
    }
}