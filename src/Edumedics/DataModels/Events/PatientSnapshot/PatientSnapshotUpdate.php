<?php


namespace Edumedics\DataModels\Events\PatientSnapshot;


use Edumedics\DataModels\Aggregate\PatientSnapshot;
use Edumedics\DataModels\Events\Event;

class PatientSnapshotUpdate extends Event
{
    /**
     * @var PatientSnapshot
     */
    public $patientSnapshot;

    /**
     * PatientSnapshotUpdate constructor.
     * @param PatientSnapshot $patientSnapshot
     */
    public function __construct(PatientSnapshot $patientSnapshot)
    {
        $this->patientSnapshot = $patientSnapshot;
    }
}