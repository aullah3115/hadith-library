<?php
namespace App\Services;

use App\Eloquent\Contracts\SectionInterface;
use Illuminate\Support\Facades\Storage;

class SectionService
{

  public function __construct(SectionInterface $repository){
    $this->repository = $repository;
  }

  public function getAll($book_id, $parent_id){

    $data = [
      'parent_id' => $parent_id,
    ];

    if ($book_id != 'null'){
      $data['book_id'] = $book_id;
    }

    $sections = $this->repository->findWhere($data);
    return $sections;
  }

  public function getByID($id){
    $section = $this->repository->find($id);
    $book = $section->book;

    $response = ['book' => $book, 'parent' => $section];
    return $response;
  }

  public function getHadith($id){
    $hadiths = $this->repository->getHadith($id);
    /*
    foreach ($hadiths as $hadith) {
      $path = 'hadith/' . $hadith->id . '.txt';
      $content = Storage::get($path);
      $hadith->body = $content;
    }
*/
    return $hadiths;
  }

  public function addSection($data){

    $section = $this->repository->createS($data);

    return $section;
  }
}
