<?php

namespace App\Services;

use App\Eloquent\Contracts\PersonInterface;

class BioAuthorService
{

  public function __construct(PersonInterface $repository){
    $this->repository = $repository;
  }

  public function getAll(){
    $authors = $this->repository->all();
    return $authors;
  }

  public function addBioAuthor($data){

    $author = $this->repository->create($data);

    return $author;
  }

  public function updateBioAuthor(){
    //TODO
  }
}
