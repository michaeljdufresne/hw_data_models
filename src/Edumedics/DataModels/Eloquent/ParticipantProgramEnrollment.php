<?php

namespace Edumedics\DataModels\Eloquent;

use Edumedics\DataModels\Events\ProgramEnrollment\ProgramEnrollmentCreate;
use Edumedics\DataModels\Events\ProgramEnrollment\ProgramEnrollmentDelete;
use Edumedics\DataModels\Events\ProgramEnrollment\ProgramEnrollmentUpdate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ParticipantProgramEnrollment extends Model
{

    use Notifiable;

    /**
     * @var string
     */
    protected $connection = 'pgsql_tenant';
    /**
     * @var string
     */
    protected $table = 'participants_programs_enrollment';

    /**
     * @var array
     */
    protected $fillable = [ 'patient_id', 'client_program_id', 'enrollment_start_date', 'enrollment_end_date',
                            'enrollment_reason', 'enrollment_note', 'disenrollment_reason', 'disenrollment_note'];
    /**
     * @var array
     */
    protected $dates = [ 'enrollment_start_date', 'enrollment_end_date' ];

    /**
     * @var array
     */
    protected $appends = [ 'programProgress' , 'hasProgress'];
    /**
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => ProgramEnrollmentCreate::class,
        'updated' => ProgramEnrollmentUpdate::class,
        'deleting' => ProgramEnrollmentDelete::class
    ];

    /**
     * @var array
     */
    public static $enrollmentReasons = [
        //0  => '',
        1  => 'Health Fair',
        2  => 'Phone call from UIC',
        3  => 'Phone call from service provider',
        4  => 'Phone call into service provider',
        5  => 'Received mailer - postcard',
        6  => 'Received mailer - letter',
        7  => 'Received mailer - other',
        8  => 'Notified in new hire HR packet',
        9  => 'HR notified about program',
        10 => 'Other',
        11 => 'Patient self-reported during Biometric Screen/Visit',
        12 => 'Program Rule Set Generated'
    ];

    /**
     * @var array
     */
    public static $disenrollmentReasons = [
        //0 => '',
        1 => 'No longer on health plan crosswalk',
        2 => 'Feels health issues are under control',
        3 => 'Does not wish to continue working with clinician',
        4 => 'Clinic site too inconvenient',
        5 => 'Clinic times too inconvenient',
        6 => 'Chose not to continue with program NOS',
        7 => 'Enrolled in different program',
        8 => 'Lost touch with member',
        9 => 'Client no longer with service provider',
        10 => 'Disenrolled by program rule set',
        11 => 'Graduated program'
    ];

    /**
     * @param $query
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * @return mixed
     */
    public function getProgramProgressAttribute()
    {
        $act2Programs = ClientsPrograms::whereHas('program',function ($query){
            $query->where('program_name','act2');
        })->pluck('id')->toArray();
        $decidePrograms = ClientsPrograms::whereHas('program',function ($query){
            $query->where('program_name','DECIDE');
        })->pluck('id')->toArray();

        if(in_array($this->client_program_id, $act2Programs))
        {
            $act2PathwayAssignment = ViimedProgramPathwayAssignment::where('patient_id',$this->patient_id)->where('program_type',1)->first();
            if(!isset($act2PathwayAssignment) || $act2PathwayAssignment->viimed_pathway_completed == 0)
            {
                return 0;
            }
            else {
                return (int)(($act2PathwayAssignment->viimed_pathway_completed/$act2PathwayAssignment->viimed_pathway_assigned) * 100);
            }
        }
        else if(in_array($this->client_program_id, $decidePrograms))
        {
            $decidePathwayAssignment = ViimedProgramPathwayAssignment::where('patient_id',$this->patient_id)->where('program_type',2)->first();
            if(!isset($decidePathwayAssignment) ||$decidePathwayAssignment->viimed_pathway_completed <= 1)
            {
                return 0;
            }
            else {
                return (int)(($decidePathwayAssignment->viimed_pathway_completed/$decidePathwayAssignment->viimed_pathway_assigned) * 100);
            }
        }
        else {
            return 0;
        }
    }

    /**
     * @return mixed
     */
    public function getHasProgressAttribute()
    {
        $act2Programs = ClientsPrograms::whereHas('program',function ($query){
            $query->where('program_name','act2');
        })->pluck('id')->toArray();
        $decidePrograms = ClientsPrograms::whereHas('program',function ($query){
            $query->where('program_name','DECIDE');
        })->pluck('id')->toArray();
        $programs = array_merge($act2Programs,$decidePrograms);
        return in_array($this->client_program_id,$programs);
    }

    /**
     * @param null $disenrollmentReason
     * @param null $endDate
     * @throws \Exception
     */
    public function disenroll($disenrollmentReason = null, $endDate = null)
    {
        $this->enrollment_end_date = isset($endDate) ? $endDate : new \DateTime();
        $this->is_active = false;
        $this->disenrollment_reason = $disenrollmentReason;
        $this->save();
    }

    /**
     * @return mixed
     */
    public function getEnrollmentReasonText()
    {
        return ParticipantProgramEnrollment::$enrollmentReasons[$this->enrollment_reason];
    }

    /**
     * @param $reason
     * @return mixed|null
     */
    public static function staticEnrollmentReasonText($reason)
    {
        if (!isset($reason)) return null;
        return ParticipantProgramEnrollment::$enrollmentReasons[$reason];
    }

    /**
     * @return mixed
     */
    public function getDisenrollmentReasonText()
    {
        return ParticipantProgramEnrollment::$disenrollmentReasons[$this->disenrollment_reason];
    }

    /**
     * @param $reason
     * @return mixed|null
     */
    public static function staticDisenrollmentReasonText($reason)
    {
        if (!isset($reason)) return null;
        return ParticipantProgramEnrollment::$disenrollmentReasons[$reason];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function clientProgram()
    {
        return $this->hasOne('Edumedics\DataModels\Eloquent\ClientsPrograms', 'id', 'client_program_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function previousProgram()
    {
        return $this->hasOne('Edumedics\DataModels\Eloquent\Program', 'id', 'previous_program_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function drchrono_patient()
    {
        return $this->hasOne('Edumedics\DataModels\Aggregate\Patient', '_id', 'patient_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function patientClients()
    {
        return $this->hasMany('Edumedics\DataModels\Eloquent\PatientClient', 'patient_id', 'patient_id');
    }

    /**
     * @return $this
     */
    public function activePatientClient()
    {
        return $this->hasOne('Edumedics\DataModels\Eloquent\PatientClient', 'patient_id', 'patient_id')->where('is_active', true);
    }

}
