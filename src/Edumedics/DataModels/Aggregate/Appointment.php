<?php

namespace Edumedics\DataModels\Aggregate;

use Edumedics\DataModels\DrChrono\Appointments;
use Edumedics\DataModels\Dto\Common\AppointmentDto;
use Edumedics\DataModels\Dto\Common\ExternalIdDto;
use Edumedics\DataModels\Events\Appointment\AppointmentCreate;
use Edumedics\DataModels\Events\Appointment\AppointmentDelete;
use Edumedics\DataModels\Events\Appointment\AppointmentUpdate;
use Edumedics\DataModels\Scopes\OmitArchivedScope;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{

    /**
     * @var string
     */
    protected $table = 'drchrono_appointments';

    /**
     * @var string
     */
    protected $connection = 'pgsql_tenant';

    /**
     * @var array
     */
    protected $dates = ['scheduled_time'];

    /**
     * @var string
     */
    protected $primaryKey = '_id';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'icd10_codes' => 'array',
        'icd9_codes' => 'array'
    ];

    /**
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => AppointmentCreate::class,
        'updated' => AppointmentUpdate::class,
        'deleting' => AppointmentDelete::class
    ];

    /**
     * TODO remove
     * @var array
     */
    protected $drChronoAppointmentFields = [
        'id', 'doctor', 'duration', 'exam_room', 'office', 'patient', 'scheduled_time', 'notes',
        'reason', 'status', 'profile', 'vitals', 'icd10_codes', 'is_walk_in', 'allow_overlapping'
    ];

    /**
     * @var array
     */
    protected $emrAppointmentFields = [
        'appointment_id','doctor_id','duration','exam_room','office_id','patient_id','scheduled_time','color','notes','profile_id',
        'reason','status','billing_status','billing_provider','billing_notes','icd10_codes','icd9_codes', 'first_billed_date',
        'last_billed_date','allow_overlapping','recurring_appointment','base_recurring_appointment','is_walk_in', 'created_at',
        'updated_at','extended_updated_at'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function drchrono_patient()
    {
        return $this->hasOne('Edumedics\DataModels\Aggregate\Patient', 'drchrono_patient_id', 'patient')
            ->withoutGlobalScope(OmitArchivedScope::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function location()
    {
        return $this->hasOne('Edumedics\DataModels\Aggregate\Office', 'drchrono_office_id', 'office');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function vitals()
    {
        return $this->hasOne('Edumedics\DataModels\Aggregate\Appointment\Vitals', 'drchrono_appointment_id', 'drchrono_appointment_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function clinicalNote()
    {
        return $this->hasOne('Edumedics\DataModels\Aggregate\Appointment\AppointmentClinicalNotes', 'drchrono_appointment_id', 'drchrono_appointment_id');
    }

    /**
     * @param AppointmentDto $emrAppointment
     */
    public function populateFromDto(AppointmentDto $emrAppointment)
    {
        if (isset($emrAppointment) && is_array($emrAppointment)) {
            foreach ($emrAppointment as $k => $v) {
                switch ($k){
                    case 'external_ids':
                        if (!empty($v))
                        {
                            foreach ($v as $externalId){
                                switch ($externalId['type']){
                                    case ExternalIdDto::DrChronoId:
                                        $this->drchrono_appointment_id = $externalId['id'];
                                        break;
                                }
                            }
                        }
                        break;
                    case 'billing_notes':
                    case 'vitals':
                    case 'clinical_note':
                        break;
                    case 'appointment_id':
                        $this->_id = $v;
                        break;
                    case 'doctor_id':
                        $this->doctor = $v;
                        break;
                    case 'office_id':
                        $this->office = $v;
                        break;
                    case 'patient_id':
                        $this->patient = $v;
                        break;
                    case 'profile_id':
                        $this->profile = $v;
                        break;
                    default:
                        $this->{$k} = $v;
                        break;
                }
            }
        }
    }

    /**
     * TODO remove
     * @param Appointments $drChronoAppointment
     */
    public function populate(Appointments $drChronoAppointment)
    {
        foreach ($this->drChronoAppointmentFields as $k)
        {
            if (isset($drChronoAppointment->{$k}))
            {
                switch ($k)
                {
                    case 'id':
                        $this->drchrono_appointment_id = $drChronoAppointment->{$k};
                        break;

                    case 'vitals':
                    case 'custom_vitals':
                        break;

                    default:
                        $this->{$k} = $drChronoAppointment->{$k};
                }
            }
        }
    }
}