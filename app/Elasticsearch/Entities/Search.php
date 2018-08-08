<?php

namespace App\Elasticsearch\Entities;

use Cviebrock\LaravelElasticsearch\Facade as ElasticSearch;

class Search
{
    //protected $index;
    //protected $query;
    protected $count;
    protected $client;

    public function __construct(){
        $this->client = new ElasticSearch; 
        
    }

    public function search($index, $query){
        if(is_array($index)){
            $index = implode(',', $index);
        }
        $this->index = $index;

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
        
            $results = $this->client::search($params);
            $this->count = $results['hits']['total'];
            return $results['hits']['hits'];
    }

    public function getCount(){
        
        return $this->count ? $this->count: false;
    }
}