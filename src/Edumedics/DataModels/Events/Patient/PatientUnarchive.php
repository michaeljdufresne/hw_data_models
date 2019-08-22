<?php

namespace Edumedics\DataModels\Events\Patient;

use Edumedics\DataModels\Aggregate\Patient;
use Edumedics\DataModels\Events\Event;

class PatientUnarchive extends Event
{

    /**
     * @var Patient
     */
    public $patient;

    /**
     * Create a new event instance.
     *
     * @param  Patient $patient
     */
    public function __construct(Patient $patient)
    {
        $this->patient = $patient;
    }

}