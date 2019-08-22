<?php

namespace Edumedics\DataModels\Events\Lab;

use Edumedics\DataModels\Aggregate\Lab;
use Edumedics\DataModels\Events\Event;

class LabUpdate extends Event
{
    public $lab;

    /**
     * Create a new event instance.
     *
     * @param Lab $lab
     */
    public function __construct(Lab $lab)
    {
        $this->lab = $lab;
    }
}