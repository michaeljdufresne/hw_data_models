<?php

namespace Edumedics\DataModels\Events\ProgramEligibility;

use Edumedics\DataModels\Eloquent\ParticipantProgramEligibility;
use Edumedics\DataModels\Events\Event;

class ProgramEligibilityUpdate extends Event
{
    /**
     * @var ParticipantProgramEligibility
     */
    public $participantProgramEligibility;

    /**
     * ProgramEligibilityUpdate constructor.
     * @param ParticipantProgramEligibility $participantProgramEligibility
     */
    public function __construct(ParticipantProgramEligibility $participantProgramEligibility)
    {
        $participantProgramEligibility->loadMissing('drchrono_patient');
        $this->participantProgramEligibility = $participantProgramEligibility;
    }
}