<?php

namespace Edumedics\DataModels\Events\Appointment;

use Edumedics\DataModels\Aggregate\Appointment;
use Edumedics\DataModels\Events\Event;

class AppointmentCreate extends Event
{

    /**
     * @var Appointment
     */
    public $appointment;

    /**
     * Create a new event instance.
     *
     * @param  Appointment $appointment
     */
    public function __construct(Appointment $appointment)
    {
        $appointment->loadMissing('drchrono_patient');
        $this->appointment = $appointment;
    }

}