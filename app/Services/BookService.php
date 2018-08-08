<?php
namespace App\Services;

use App\Eloquent\Contracts\BookInterface;
use Cviebrock\LaravelElasticsearch\Facade as ElasticSearch;
use TSF\Neo4jClient\Facades\Neo4jClient;

class BookService
{

  public function __construct(BookInterface $repository){
    $this->repository = $repository;
  }

  public function getAll(){
    $books = $this->repository->getAll();
    return $books;
  }

  public function getTree(){

    $tree = Neo4jClient::run(
      "match q = (l:Library)-[:CONTAINS*]-(b) 
      where not b:Hadith 
      with COLLECT(q) as qu 
      Call apoc.convert.toTree(qu) yield value 
      return value")->getRecord()->value('value');
    
    return $tree;
  }

  public function getByID($id){
    $book = $this->repository->find($id);
    return $book;
  }

  public function addBook($data){

    $book = $this->repository->addBook($data);
    $name = $data['name'];
    $id = $book->id;
    $neo_book = Neo4jClient::run("MERGE (a:Library) MERGE (b:Book {name: '{$name}', sql_id: {$id} }) MERGE (a)-[:CONTAINS]->(b)");

    return $book;
  }

  public function updateBook($data){
    
    $book = $this->repository->updateBook($data);
    $old_name = $data['old_name'];
    $name = $data['name'];

    $query = "MATCH (hadith:Hadith {book: {$old_name} }) SET hadith.book = {$name}";

    Neo4jClient::run($query);
    
    $update = [
      'index'     => 'hadith',
      'type'      => '_doc',
      'conflicts' => 'proceed',
      'body' => [
          'query' => [
              'query_string' => [
                'fields' => ['book'],
                'query' => "\"{$data['old_name']}\"",
              ]
          ],
          
          'script' => [
              'lang' => 'painless',
              'inline' => 'ctx._source.book = params.book',
                  'params' => [
                      'book' => $data['name'],
                  ]
              ]
            
      ]
  ]; // TODO make into job
    $results = ElasticSearch::updateByQuery($update);

    return $book;
  }
}
