<?php

namespace App\Mail;

use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EventJoinedCreator extends Mailable
{
    use Queueable, SerializesModels;

    public $event;
    public $participant;

    public function __construct(Event $event, $participant)
    {
        $this->event = $event;
        $this->participant = $participant;
    }

    public function build()
    {
        return $this->view('emails.eventJoinedCreator')
            ->with(['event' => $this->event, 'participant' => $this->participant]);
    }
}

