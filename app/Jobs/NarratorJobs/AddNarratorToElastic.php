<?php

namespace App\Jobs\NarratorJobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Cviebrock\LaravelElasticsearch\Facade as ElasticSearch;

class AddNarratorToElastic implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;
    public $id;
    public $tries = 5;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data, $id)
    {
        $this->data = $data;
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $elastic_data = [
          'body' => $this->data,
          'index' => 'narrator',
          'type' => '_doc',
          'id' => $this->id,
        ];

        try {
          $results = ElasticSearch::index($elastic_data);
        } catch (\Exception $e) {
          Storage::append('logs/errors.log', $e->getMessage() . PHP_EOL);
        }

    }
}
