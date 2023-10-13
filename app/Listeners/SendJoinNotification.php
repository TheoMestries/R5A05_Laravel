<?php

namespace App\Listeners;

use App\Events\UserJoinedEvent;
use App\Mail\EventJoinedCreator;
use App\Mail\EventJoinedUser;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendJoinNotification
{
    use InteractsWithQueue;

    public function handle( UserJoinedEvent $event )
    {
        Mail::to($event->user->email)->send(new EventJoinedUser($event->event));

        Mail::to($event->event->user->email)->send(new EventJoinedCreator($event->event, $event->user));
    }
}
