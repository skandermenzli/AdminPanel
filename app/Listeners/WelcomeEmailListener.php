<?php

namespace App\Listeners;

use App\Events\UserCreated;
use App\Mail\Welcome;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class WelcomeEmailListener implements ShouldQueue
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
     * @param  \App\Events\UserCreated  $event
     * @return void
     */
    public function handle(UserCreated $event)
    {
        Mail::to($event->user)->send(new welcome($event->user));
    }
}
