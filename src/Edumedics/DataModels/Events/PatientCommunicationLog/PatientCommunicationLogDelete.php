<?php

namespace Edumedics\DataModels\Events\PatientCommunicationLog;

use Edumedics\DataModels\Eloquent\PatientCommunicationLog;
use Edumedics\DataModels\Events\Event;

class PatientCommunicationLogDelete extends Event
{
    /**
     * @var PatientCommunicationLog
     */
    public $patientCommunicationLog;

    /**
     * PatientCommunicationLogDelete constructor.
     * @param PatientCommunicationLog $patientCommunicationLog
     */
    public function __construct(PatientCommunicationLog $patientCommunicationLog)
    {
        $this->patientCommunicationLog = $patientCommunicationLog;
    }
}