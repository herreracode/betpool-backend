<?php

namespace BetPool\Events;

use Illuminate\Queue\SerializesModels;

abstract class Event
{
    use SerializesModels;
}
