<?php

namespace App\Listeners;

use App\Mail\ForgotPasswordTokenMail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Mail;

class SendForgotPasswordNotification
{
    /**
     * Create the event listener.
     */
    public function __construct(public User $user)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $user   = $event->user;
        $token  = $event->token;
        Mail::to($user->email)->send(new ForgotPasswordTokenMail($user, $token));
    }
}
