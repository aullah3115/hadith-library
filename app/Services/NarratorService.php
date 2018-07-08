<?php

namespace App\Services;

use App\Jobs\NarratorJobs\AddNarratorToNeo4j;
use App\Jobs\NarratorJobs\AddNarratorToElastic;

use App\Eloquent\Contracts\PersonInterface;
use App\NeoEloquent\Entities\Narrator as NeoNarrator;

class NarratorService
{

  public function __construct(PersonInterface $repository){
    $this->repository = $repository;
  }

  public function getAll(){
    $narrators = $this->repository->all();
    return $narrators;
  }

  public function addNarrator($data){

    $narrator = $this->repository->create($data);
    $id = $narrator->id;

    AddNarratorToElastic::dispatch($data, $id);

    $data['sql_id'] = $id;

    AddNarratorToNeo4j::dispatch($data);


    return $narrator;
  }

  public function updateAuthor(){
    //TODO
  }
}
