<?php

namespace App\Jobs\HadithJobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Cviebrock\LaravelElasticsearch\Facade as ElasticSearch;

use App\Elasticsearch\Entities\Hadith as ElasticHadith;

class AddHadithToElastic implements ShouldQueue
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
    public function __construct($id, $data)
    {
        $this->id = $id;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $elastic_hadith = new ElasticHadith;
        $elastic_hadith->create($this->id, $this->data);
        /*
        $data = $this->data;

        $elastic_data = [
        'body' => [
            'body' => $data['body'],
            'chain' => $data['chain'],
            'book' => $data['book'],
            'section' => $data['section'],
        ],
        'index' => 'hadith',
        'type' => '_doc',
        'id' => $data['id'],
        ];
        try {
          $results = ElasticSearch::index($elastic_data);
        } catch (\Exception $e) {

        }
        */

    }
}
