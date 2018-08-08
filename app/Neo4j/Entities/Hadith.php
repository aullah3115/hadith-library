<?php

namespace App\Neo4j\Entities;

use TSF\Neo4jClient\Facades\Neo4jClient;

class Hadith
{
    protected $client;
    protected $query;
    public $values = [
        "id" => null,
        "chain" => null,
        "number" => null,
        "blurb" => null,
        "section_id" => null,
        "book" => null,
        "section" => null,
    ];

    public function __construct(){
        $this->client = new Neo4jClient;
    }

    public function valuesExist(){
        foreach ($this->values as $key => $value) {
            if(!$value){
                return false;
            }
        }
        return true;
    }

    public function setQuery(){
        $section_id = $this->values['section_id'];
        $id = $this->values['id'];
        $chain = $this->values['chain'];
        $number = $this->values['number'];
        $blurb = $this->values['blurb'];
        $book = $this->values['book'];
        $section = $this->values['section'];

        $this->query = "MATCH (a:Section {sql_id: {$section_id} }) WITH a 
        MERGE (b:Hadith {sql_id: {$id}, number: {$number}, chain: '{$chain}', blurb: '{$blurb}', book: '{$book}', section: '{$section}' })
        MERGE (a)-[:CONTAINS]->(b)";
    }

    public function create($data = null){
        if($data && is_array($data)){
            $this->values = $data;
        }

        if(!$this->valuesExists()){
            return false;
        }

        $this->setQuery();
        $this->client::run($this->query);

    }
}