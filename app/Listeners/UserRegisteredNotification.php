<?php

namespace App\Listeners;

use App\Mail\UserRegisteredMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Mail;

class UserRegisteredNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $user = $event->user;
        Mail::to($user->email)->send(new UserRegisteredMail($user));
    }
}
