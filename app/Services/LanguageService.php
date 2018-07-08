<?php
namespace App\Services;

use App\Eloquent\Contracts\LanguageInterface;
use Illuminate\Support\Facades\Storage;

class LanguageService
{

  public function __construct(LanguageInterface $repository){
    $this->repository = $repository;
  }

  public function addLanguage($data){
    $language = $this->repository->create($data);


    return $language;
  }

  public function getAll(){
    $languages = $this->repository->all();

    return $languages;
  }

}
