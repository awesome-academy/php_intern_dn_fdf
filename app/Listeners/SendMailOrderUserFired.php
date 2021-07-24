<?php

namespace App\Listeners;

use App\Events\SendMailOrderUser;
use App\Mail\MailOrderUser;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMailOrderUserFired implements ShouldQueue
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
     * @param  SendMailOrderUser  $event
     * @return void
     */
    public function handle(SendMailOrderUser $event)
    {
        Mail::to($event->order->user->email)
        ->send(new MailOrderUser($event->order));
    }
}
