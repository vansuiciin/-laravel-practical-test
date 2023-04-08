<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SurveySubmitEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $name;
    public $phone_number;
    public $date_of_birth;
    public $gender;
    /**
     * Create a new event instance.
     *
     * @param string $email
     * @param string $name
     * @param string $phone_number
     * @param string $date_of_birth
     * @param string $gender
     * @return void
     */
   
     public function __construct($email ,$name, $phone_number, $date_of_birth, $gender)
    {
        $this->email = $email;
        $this->name = $name;
        $this->phone_number = $phone_number;
        $this->date_of_birth = $date_of_birth;
        $this->gender = $gender;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
