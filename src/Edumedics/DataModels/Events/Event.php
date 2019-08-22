<?php

namespace Edumedics\DataModels\Events;

use Edumedics\DataModels\Traits\EventHelperTrait;
use SentryHealth\Kafka\Traits\MultiTenantSerializesModels;

abstract class Event
{
    use MultiTenantSerializesModels, EventHelperTrait;
}
