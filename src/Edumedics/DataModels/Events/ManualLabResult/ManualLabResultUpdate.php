<?php

namespace Edumedics\DataModels\Events\ManualLabResult;

use Edumedics\DataModels\Aggregate\ManualLabResult;
use Edumedics\DataModels\Events\Event;

class ManualLabResultUpdate extends Event
{

    public $lab;

    /**
     * Create a new event instance.
     *
     * @param $lab
     */
    public function __construct(ManualLabResult $lab)
    {
        $this->lab = $lab;
    }

}