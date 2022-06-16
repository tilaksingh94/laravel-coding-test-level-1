<?php

namespace App\Listeners;

use App\Event\eventCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendEmail
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
     * @param  eventCreated  $event
     * @return void
     */
    public function handle(eventCreated $event)
    {
        Mail::send(['text' => 'mail'], array(), function ($message) {
            $message->to('t.singh3713@gmail.com', 'RAj')->subject('Event Created');
            $message->from('coolcrm@gmail.com', 'Cool CRM');
        });
    }
}
