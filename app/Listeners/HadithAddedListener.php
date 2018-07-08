<?php

namespace App\Listeners;

use App\Events\HadithAdded;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class HadithAddedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  HadithAdded  $event
     * @return void
     */
    public function handle(HadithAdded $event)
    {
        //
    }
}
