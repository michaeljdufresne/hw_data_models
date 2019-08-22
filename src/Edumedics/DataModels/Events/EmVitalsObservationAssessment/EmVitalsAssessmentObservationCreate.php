<?php


namespace Edumedics\DataModels\Events\EmVitalsAssessmentObservation;


use Edumedics\DataModels\Eloquent\EmVitalsAssessmentObservation;
use Edumedics\DataModels\Events\Event;


class EmVitalsAssessmentObservationCreate extends Event
{

    /**
     * @var EmVitalsAssessmentObservation
     */
    public $emVitalsAssessmentObservation;

    /**
     * EmVitalsObservationAssessmentCreate constructor.
     * @param EmVitalsAssessmentObservation $emVitalsAssessmentObservation
     */
    public function __construct(EmVitalsAssessmentObservation $emVitalsAssessmentObservation)
    {
        $this->emVitalsAssessmentObservation = $emVitalsAssessmentObservation;
    }
}