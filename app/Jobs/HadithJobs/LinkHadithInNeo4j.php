<?php

namespace App\Jobs\HadithJobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use TSF\Neo4jClient\Facades\Neo4jClient;

class LinkHadithInNeo4j implements ShouldQueue
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

        Neo4jClient::run(
         "MATCH(first_hadith:Hadith {sql_id: {$data['hadith_1_id']} })
         MATCH(second_hadith:Hadith {sql_id: {$data['hadith_2_id']} })
         WITH first_hadith, second_hadith
         MERGE(first_hadith)-[:RELATED_TO]->(second_hadith)"
       );
    }
}
