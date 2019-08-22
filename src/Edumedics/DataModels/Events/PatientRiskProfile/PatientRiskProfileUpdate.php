<?php


namespace Edumedics\DataModels\Events\PatientRiskProfile;

use Edumedics\DataModels\Eloquent\PatientRiskProfile;
use Edumedics\DataModels\Events\Event;

class PatientRiskProfileUpdate extends Event
{
    /**
     * @var PatientRiskProfile
     */
    public $patientRiskProfile;

    /**
     * PatientRiskProfileCreate constructor.
     * @param PatientRiskProfile $patientRiskProfile
     */
    public function __construct(PatientRiskProfile $patientRiskProfile)
    {
        $patientRiskProfile->loadMissing('drchrono_patient');
        $this->patientRiskProfile = $patientRiskProfile;
    }
}