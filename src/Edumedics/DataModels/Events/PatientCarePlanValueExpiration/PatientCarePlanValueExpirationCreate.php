<?php


namespace Edumedics\DataModels\Events\PatientCarePlanValueExpiration;


use Edumedics\DataModels\Eloquent\PatientCarePlanValueExpiration;
use Edumedics\DataModels\Events\Event;

class PatientCarePlanValueExpirationCreate extends Event
{

    /**
     * @var PatientCarePlanValueExpiration
     */
    public $patientCarePlanValueExpiration;

    /**
     * PatientCarePlanCreate constructor.
     * @param PatientCarePlanValueExpiration $patientCarePlanValueExpiration
     */
    public function __construct(PatientCarePlanValueExpiration $patientCarePlanValueExpiration)
    {
        $patientCarePlanValueExpiration->loadMissing('drchrono_patient');
        $this->patientCarePlanValueExpiration = $patientCarePlanValueExpiration;
    }

}