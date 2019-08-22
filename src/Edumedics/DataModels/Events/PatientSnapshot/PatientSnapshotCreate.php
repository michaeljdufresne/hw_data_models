<?php


namespace Edumedics\DataModels\Events\PatientSnapshot;


use Edumedics\DataModels\Aggregate\PatientSnapshot;
use Edumedics\DataModels\Events\Event;

class PatientSnapshotCreate extends Event
{
    /**
     * @var PatientSnapshot
     */
    public $patientSnapshot;

    /**
     * PatientSnapshotCreate constructor.
     * @param PatientSnapshot $patientSnapshot
     */
    public function __construct(PatientSnapshot $patientSnapshot)
    {
        $this->patientSnapshot = $patientSnapshot;
    }
}