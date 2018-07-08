<?php

namespace App\Services;

use App\Eloquent\Contracts\HadithTranslationInterface;
use App\Eloquent\Entities\HadithTranslation;

use Illuminate\Support\Facades\Storage;

class HadithTranslationService
{

  public function __construct(HadithTranslationInterface $repository){
    $this->repository = $repository;
  }

  public function getAll(){
    $translations = $this->repository->all();
    return $translations;
  }

  public function translationsForHadith($id){
    $translations = $this->repository->translationsForHadith($id);
    foreach ($translations as $translation) {
      $path = 'translations/hadith/' . $translation->id . '.txt';
      $text = Storage::get($path);
      $translation->text = $text;
    }
    return $translations;
  }

  public function addTranslation($data){

    $translation = $this->repository->addTranslation([
      'hadith_id' => $data['hadith_id'],
      'language_id' => $data['language_id']
    ]);

    $id = $translation->id;
    $path = 'translations/hadith/' . $id . '.txt';

    //$text_file = tmpfile();
    //fwrite($text_file, $data['text']);
    //$path = realpath('text.txt');

    Storage::put($path, $data['text']);
    //fclose($text_file);

    $content = Storage::get($path);
    $translation->text = $content;

    return $translation;
  }

  public function updateTranslation(){
    //TODO
  }
}
