<?php

namespace App\Jobs\HadithJobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Events\HadithAdded;

use App\NeoEloquent\Entities\Hadith as NeoHadith;

class AddHadithToNeo4j implements ShouldQueue
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
      if ($this->attempts() > 5) {
        return;
    }
        $data = $this->data;

        $neo_hadith = NeoHadith::create([
          'sql_id' => $data['id'],
          'number' => $data['number'],
          'blurb' => $data['blurb'],
          'book' => $data['book'],
          'section' => $data['section'],
        ]);

        //event(new HadithAdded);
    }
}
