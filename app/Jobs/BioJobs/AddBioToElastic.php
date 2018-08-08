<?php

namespace App\Jobs\BioJobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Cviebrock\LaravelElasticsearch\Facade as ElasticSearch;

class AddBioToElastic implements ShouldQueue //TODO no longer required DELETE
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;
    public $tries = 5;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
      $data = $this->data;

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
    }
}
