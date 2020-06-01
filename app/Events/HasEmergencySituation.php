<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Models\UrgentContact;

class HasEmergencySituation
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The model is to be injected.
     */
    public $urgentContact;

    /**
     * The questionnaire will be saved to urgent_contact_detail_statuses table
     */
    // public $questionnaire;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(UrgentContact $urgentContact)
    {
        throw_if(is_null($questionnaire = $urgentContact->questionnaire) || empty($questionnaire),
                \UnexpectedValueException::class, 'Questionnaire must not be empty.');

        $this->urgentContact = $urgentContact;
        // The questionnaire is attached to current Instance UrgentContact,
        // If UrgentContact is to be serialized, it will be vanish.
        // So consider to save it to a new variable.
        //$this->questionnaire = $urgentContact->questionnaire;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
