<?php

namespace Edumedics\DataModels\Aggregate\Appointment;

use Edumedics\DataModels\DrChrono\Appointments\AppointmentClinicalNote;
use Edumedics\DataModels\Dto\Common\Appointment\ClinicalNoteDto;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AppointmentClinicalNotes
 * @package Edumedics\DataModels\Aggregate\Appointment
 */
class AppointmentClinicalNotes extends Model
{

    /**
     * @var string
     */
    protected $table = 'drchrono_appointment_clinical_notes';

    /**
     * @var string
     */
    protected $connection = 'pgsql_tenant';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function appointment()
    {
        return $this->belongsTo('Edumedics\DataModels\Aggregate\Appointment', 'drchrono_appointment_id', 'drchrono_appointment_id');
    }

    /**
     * @param AppointmentClinicalNote $clinicalNote
     */
    public function populate(AppointmentClinicalNote $clinicalNote)
    {
        foreach ($clinicalNote->jsonSerialize() as $k => $v)
        {
            $this->{$k} = $v;
        }
    }

    public function populateFromDto(ClinicalNoteDto $clinicalNote, $appointmentId)
    {
        $this->drchrono_appointment_id = $appointmentId;
        foreach ($clinicalNote->jsonSerialize() as $k => $v)
        {
           switch ($k){
               case 'locked':
                   $this->locked = $v;
                   break;
               case 'resource_uri':
                   $this->pdf = $v;
                   break;
               default:
                   $this->{$k} = $v;
                   break;
           }
        }
    }

}