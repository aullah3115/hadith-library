<?php

namespace App\Services;

use App\Eloquent\Contracts\HadithTranslationInterface;
use App\Eloquent\Entities\HadithTranslation;
use App\Eloquent\Entities\Language;

use Illuminate\Support\Facades\Storage;
use Cviebrock\LaravelElasticsearch\Facade as ElasticSearch;

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
      $language_name = strtolower($translation->language->name);
      $path = 'translations/hadith/' . $language_name . '/' . $translation->id . '.txt';
      $text = Storage::get($path);
      $translation->text = $text;
    }
    return $translations;
  }

  public function addTranslation($data){

    $translation = $this->repository->addTranslation([
      'hadith_id' => $data['hadith_id'],
      'language_id' => $data['language_id'],
      'translator' => $data['translator'],
    ]);
    $language_name = strtolower($data['language_name']);

    $id = $translation->id;
    $path = 'translations/hadith/' . $language_name . '/' . $id . '.txt';

    Storage::put($path, $data['text']);
    $index_name = 'hadith_translation_' . $language_name;
    try {
      $exists = ElasticSearch::indices()->exists(['index' => $index_name]);
      // if hadith index doesn't exist create new index
      if(!$exists){
        $params = [
          'index' => $index_name,
          'body' => [
            'mappings' => [
              '_doc' => [
                'properties' => [
                  'text' => [
                    'type' => 'text',
                  ],
                  'language' => [
                    'type' => 'text',
                  ],
                  'translator' => [
                    'type' => 'text',
                  ]
                ]
              ]
            ]
          ]
      ];

      $response = ElasticSearch::indices()->create($params);
      }
      $elastic_data = [
        'body' => [
            'text' => $data['text'],
            'language' => $data['language_name'],
            'translator' => $data['translator'],
        ],
        'index' => $index_name,
        'type' => '_doc',
        'id' => $id,
        ];
      $results = ElasticSearch::index($elastic_data);
    } catch (\Exception $e) {
      return $e->getMessage();
    }
    $content = $data['text'];
    $translation->text = $content;

    return $translation;
  }

  public function updateTranslation(){
    //TODO
  }
}
