<?php

namespace App\Events;

use App\Models\CardList;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CardListCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public User $owner;
    public CardList $cardList;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $owner, CardList $cardList)
    {
        $this->owner = $owner;
        $this->cardList = $cardList;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn(): Channel|array
    {
        return new Channel('cardlist-channel');
    }
}
