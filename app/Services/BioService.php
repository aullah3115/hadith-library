<?php
namespace App\Services;

use App\Jobs\BioJobs\AddBioToElastic;

use App\Eloquent\Contracts\BioInterface;
use Cviebrock\LaravelElasticsearch\Facade as ElasticSearch;
use Illuminate\Support\Facades\Storage;

class BioService
{

  public function __construct(BioInterface $repository){
    $this->repository = $repository;
  }

  public function addBio($data){

    $text = $data['text'];

    $blurb = strlen($text) > 200 ? substr($text, 0, 200) . '...' : $text;

    $bio = $this->repository->addBio([
      'narrator_id' => $data['narrator_id'],
      'bio_book_id' => $data['bio_book_id'],
      'blurb' => $blurb,
    ]);

    $data['id'] = $bio->id;

    $elastic_data = [
    'body' => [
        'text' => $data['text'],
        'narrator' => $data['narrator'],
        'book' => $data['book'],
    ],
    'index' => 'bio',
    'type' => '_doc',
    'id' => $data['id'],
    ];
    try {
      $results = ElasticSearch::index($elastic_data);
    } catch (\Exception $e) {

    }
    //AddBioToElastic::dispatch($data);

    $path = 'bio/' . $data['id'] . '.txt';
    Storage::put($path, $data['text'], 'private');
    $bio->text = $text;

    return $bio;
  }

  public function getBioText($id){
    $path = 'bio/' . $id . '.txt';
    return Storage::get($path);
/*
    $params = [
      'index' => 'bio',
      'type' => '_doc',
      'id' => $id,
      '_source' => ['text'],
    ];

    try {
        $results = Elasticsearch::get($params);
        return $results['_source']['text'];

    } catch (\Exception $e) {
        return $e->getMessage();
    }
    */
  }

  public function biosForNarrator($id){
    $bios = $this->repository->findByField('narrator_id', $id);

    foreach ($bios as $bio) {
      $bio->source = $bio->load('source');
    }

    return $bios;
  }
}
