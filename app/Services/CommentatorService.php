<?php

namespace App\Services;

use App\Eloquent\Contracts\PersonInterface;

class CommentatorService
{

  public function __construct(PersonInterface $repository){
    $this->repository = $repository;
  }

  public function getAll(){
    $commentators = $this->repository->all();
    return $commentators;
  }

  public function addCommentator($data){

    $commentator = $this->repository->create($data);

    return $commentator;
  }

  public function updateCommentator(){
    //TODO
  }
}
