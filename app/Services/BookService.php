<?php
namespace App\Services;

use App\Eloquent\Contracts\BookInterface;

class BookService
{

  public function __construct(BookInterface $repository){
    $this->repository = $repository;
  }

  public function getAll(){
    $books = $this->repository->all();
    return $books;
  }

  public function getByID($id){
    $book = $this->repository->find($id);
    return $book;
  }

  public function addBook($data){

    $book = $this->repository->create($data);

    return $book;
  }
}
