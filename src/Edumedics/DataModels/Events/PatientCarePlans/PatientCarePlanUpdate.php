<?php


namespace Edumedics\DataModels\Events\PatientCarePlans;

use Edumedics\DataModels\Eloquent\PatientCarePlans;
use Edumedics\DataModels\Events\Event;

class PatientCarePlanUpdate extends Event
{
    /**
     * @var PatientCarePlans
     */
    public $patientCarePlan;

    /**
     * PatientCarePlanUpdate constructor.
     * @param PatientCarePlans $patientCarePlan
     */
    public function __construct(PatientCarePlans $patientCarePlan)
    {
        $patientCarePlan->loadMissing('drchrono_patient');
        $this->patientCarePlan = $patientCarePlan;
    }


}