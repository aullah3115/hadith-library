<?php

namespace App\Services;

use App\Eloquent\Contracts\CommentaryInterface;

class CommentaryService
{

  public function __construct(CommentaryInterface $repository){
    $this->repository = $repository;
  }

  public function getAll(){
    $commentaries = $this->repository->all();
    return $commentaries;
  }

  public function getForBook($id){
    $commentaries = $this->repository->findByField('book_id', $id);
    return $commentaries;
  }

  public function addCommentary($data){

    $commentary = $this->repository->create($data);

    return $commentary;
  }

  public function updateCommentary(){
    //TODO
  }
}
