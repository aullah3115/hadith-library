<?php

namespace App\Events;

use Illuminate\Support\Facades\Auth;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class HadithAdded implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

   // public $message = "A new hadith has been added";
    public $user;
    protected $hadith;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->user = Auth::user();

    }

    public function hadith($hadith){
        $this->hadith = $hadith;
        return $this;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return [new PrivateChannel('user'. $this->user->id), new Channel('all')];
    }

    public function broadcastWith()
    {
        return ['hadith' => $this->hadith, 'added_by' => $this->user];
    }
}
