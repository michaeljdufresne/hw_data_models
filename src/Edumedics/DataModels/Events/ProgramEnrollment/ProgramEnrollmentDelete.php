<?php


namespace Edumedics\DataModels\Events\ProgramEnrollment;


use Edumedics\DataModels\Eloquent\ParticipantProgramEnrollment;
use Edumedics\DataModels\Events\Event;

class ProgramEnrollmentDelete extends Event
{
    /**
     * @var ParticipantProgramEnrollment
     */
    public $participantProgramEnrollment;

    /**
     * ProgramEnrollmentDelete constructor.
     * @param ParticipantProgramEnrollment $participantProgramEnrollment
     */
    public function __construct(ParticipantProgramEnrollment $participantProgramEnrollment)
    {
        $participantProgramEnrollment->loadMissing('drchrono_patient');
        $this->participantProgramEnrollment = $participantProgramEnrollment;
    }
}