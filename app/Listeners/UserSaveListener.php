<?php

namespace App\Listeners;

use Carbon\Carbon;
use App\Mail\EmailVerify;
use App\Events\UserSaveEvent;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserSaveListener  
{
    public function handle(UserSaveEvent $event)
    {
        // Only want to send if this is false
        if ($event->user->email_confirmed == true) {
            return;
        } elseif ($event->user->email_confirmation_sent != null) {
            return;
        }

        $event->user->email_confirmation_sent = Carbon::now();
        $event->user->save();

        Mail::to($event->user->email)->send(new EmailVerify($event->user));

        return;
    } // end handle
}
