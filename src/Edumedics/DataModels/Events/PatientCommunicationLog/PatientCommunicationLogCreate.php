<?php

namespace Edumedics\DataModels\Events\PatientCommunicationLog;

use Edumedics\DataModels\Eloquent\PatientCommunicationLog;
use Edumedics\DataModels\Events\Event;

class PatientCommunicationLogCreate extends Event
{
    /**
     * @var PatientCommunicationLog
     */
    public $patientCommunicationLog;

    /**
     * PatientCommunicationLogCreate constructor.
     * @param PatientCommunicationLog $patientCommunicationLog
     */
    public function __construct(PatientCommunicationLog $patientCommunicationLog)
    {
        $this->patientCommunicationLog = $patientCommunicationLog;
    }
}