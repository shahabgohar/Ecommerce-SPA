<?php

namespace App\Listeners;

use App\Mail\ResetPasswordSuccess;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class PasswordResetSuccess
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
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
       Mail::to($event->user->email)->later(now()->addSeconds(10),new ResetPasswordSuccess($event->user));
    }
}
