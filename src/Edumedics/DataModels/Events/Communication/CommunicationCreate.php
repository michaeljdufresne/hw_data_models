<?php

namespace Edumedics\DataModels\Events\Communication;

use Edumedics\DataModels\Aggregate\Communication;
use Edumedics\DataModels\Events\Event;

class CommunicationCreate extends Event
{

    public $communication;

    /**
     * Create a new event instance.
     *
     * @param Communication $communication
     */
    public function __construct(Communication $communication)
    {
        $this->communication = $communication;
    }

}