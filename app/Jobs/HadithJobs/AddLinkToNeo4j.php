<?php

namespace App\Jobs\HadithJobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use TSF\Neo4jClient\Facades\Neo4jClient;

class AddLinkToNeo4j implements ShouldQueue
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

      $position = (int)$data['position'];
      $hadith_id = (int)$data['hadith_id'];
      $narrator_id = (int)$data['narrator_id'];

      
      Neo4jClient::run(
        "MATCH(narrator: Narrator { sql_id: {$narrator_id}})
        MATCH(hadith: Hadith { sql_id : {$hadith_id}})
        WITH hadith, narrator
        MERGE(link: Link { position : {$position}, hadith_id : {$hadith_id}})
        MERGE(narrator)-[:OF]->(link)-[:BELONGS_TO]->(hadith)"
      );

      $prev_pos = $position - 1;

      if($prev_pos > 0){
          Neo4jClient::run(
            "MATCH(current_link: Link { position : {$position}, hadith_id : {$hadith_id}})
            MATCH(previous_link: Link { position : {$prev_pos}, hadith_id : {$hadith_id}})
            WITH current_link, previous_link
            MERGE(current_link)-[:FROM]->(previous_link)"
          );

        }



    }
}
