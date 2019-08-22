<?php

namespace Edumedics\DataModels\Events\ProgramEnrollment;


use Edumedics\DataModels\Eloquent\ParticipantProgramEnrollment;
use Edumedics\DataModels\Events\Event;

class ProgramEnrollmentCreate extends Event
{
    /**
     * @var ParticipantProgramEnrollment
     */
    public $participantProgramEnrollment;

    /**
     * ProgramEnrollmentCreate constructor.
     * @param ParticipantProgramEnrollment $participantProgramEnrollment
     */
    public function __construct(ParticipantProgramEnrollment $participantProgramEnrollment)
    {
        $participantProgramEnrollment->loadMissing('drchrono_patient');
        $this->participantProgramEnrollment = $participantProgramEnrollment;
    }

}