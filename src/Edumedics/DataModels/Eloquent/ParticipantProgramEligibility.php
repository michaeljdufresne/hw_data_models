<?php

namespace Edumedics\DataModels\Eloquent;

use Edumedics\DataModels\Events\ProgramEligibility\ProgramEligibilityCreate;
use Edumedics\DataModels\Events\ProgramEligibility\ProgramEligibilityDelete;
use Edumedics\DataModels\Events\ProgramEligibility\ProgramEligibilityUpdate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ParticipantProgramEligibility extends Model
{

    use Notifiable;


    /**
     * @var string
     */
    protected $connection = 'pgsql_tenant';
    /**
     * @var string
     */
    protected $table = 'participants_programs_eligibility';

    /**
     * @var array
     */
    protected $fillable = ['patient_id', 'client_program_id', 'eligibility_start_date', 'eligibility_end_date'];

    /**
     * @var array
     */
    protected $dates = [ 'eligibility_start_date', 'eligibility_end_date' ];

    /**
     * @var array
     */
    protected $appends = [ 'programInviteSent' , 'usesInvite' ];

    /**
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => ProgramEligibilityCreate::class,
        'updated' => ProgramEligibilityUpdate::class,
        'deleting' => ProgramEligibilityDelete::class
    ];

    /**
     * @var array
     */
    public static $eligibilityOrigins = [
        1 => 'Patient Reported',
        2 => 'Eligibility Import',
        3 => 'Clinical Risk Generated',
        4 => 'Program Rule Set Generated'
    ];

    /**
     * @return mixed
     */
    public function getProgramInviteSentAttribute()
    {
        $act2Programs = ClientsPrograms::whereHas('program',function ($query){
            $query->where('program_name','act2');
        })->pluck('id')->toArray();
        $decidePrograms = ClientsPrograms::whereHas('program',function ($query){
            $query->where('program_name','DECIDE');
        })->pluck('id')->toArray();

        if(in_array($this->client_program_id, $act2Programs)){
            $act2PathwayAssignment = ViimedProgramPathwayAssignment::where('patient_id',$this->patient_id)->where('program_type',1)->count();
            return $act2PathwayAssignment > 0;
        }else if(in_array($this->client_program_id, $decidePrograms)){
            $decidePathwayAssignment = ViimedProgramPathwayAssignment::where('patient_id',$this->patient_id)->where('program_type',2)->count();
            return $decidePathwayAssignment > 0;
        }else{
            return false;
        }
    }

    /**
     * @return mixed
     */
    public function getUsesInviteAttribute()
    {
        if(!$this->is_active)
            return false;

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
     * @param $query
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * @param null $endDate
     * @throws \Exception
     */
    public function expire($endDate = null)
    {
        $this->eligibility_end_date = isset($endDate) ? $endDate : new \DateTime();
        $this->is_active = false;
        $this->save();
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
