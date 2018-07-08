<?php
namespace App\Services;

use App\Eloquent\Contracts\BioInterface;
use Illuminate\Support\Facades\Storage;

class BioService
{

  public function __construct(BioInterface $repository){
    $this->repository = $repository;
  }

  public function addBio($data){
    $bio = $this->repository->addBio([
      'narrator_id' => $data['narrator_id'],
      'bio_book_id' => $data['bio_book_id'],
    ]);

    $id = $bio->id;
    $path = 'bio/' . $id . '.txt';

    //$text_file = tmpfile();
    //fwrite($text_file, $data['text']);

    Storage::put($path, $data['text']);
    //fclose($text_file);

    $content = Storage::get($path);
    $bio->text = $content;

    return $bio;
  }

  public function biosForNarrator($id){
    $bios = $this->repository->findByField('narrator_id', $id);

    foreach ($bios as $bio) {
      $path = 'bio/' . $bio->id . '.txt';
      $text = Storage::get($path); // load this later
      $bio->text = $text;
      $bio->source = $bio->load('source');
    }

    return $bios;
  }
}
