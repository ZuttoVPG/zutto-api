<?php

namespace App\Events;

use App\Models\User;
use App\Events\Event;

class UserSaveEvent extends Event
{
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    } // end __construct

} // end UserSaveEvent
