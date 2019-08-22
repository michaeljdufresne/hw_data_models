<?php

namespace Edumedics\DataModels\Eloquent;

use Illuminate\Database\Eloquent\Model;

class PatientCommunicationResults extends Model
{
    /**
     * @var string
     */
    protected $connection = 'pgsql_tenant';

    /**
     * @var string
     */
    protected $table = 'patient_communication_results';

    /**
     * @var array
     */
    protected $fillable = ['communication_log_id','result','appointment_text','appointment_date','email_text','task_id','mail_sent','enrollment_text'];

    public $appends = ['result_text', 'reasons'];
    /**
     * @var array
     */
    public static $communicationResults = [
        1 => 'Scheduled Appointment',
        2 => 'Sent Consent Forms/Requested More Information',
        3 => 'Left Message & No Answer',
        4 => 'Call Back Later',
        5 => 'Wrong Number',
        6 => 'Not Interested at This Time',
        7 => 'Do Not Contact',
        8 => 'Already Enrolled',
        9 => 'Does Not Speak English',
        10 => 'No Longer on Health Plan',
        11 => 'Number Disconnected'
    ];

    public function getResultTextAttribute()
    {
        return self::$communicationResults[$this->result];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function log(){
        return $this->hasOne('Edumedics\DataModels\Eloquent\PatientCommunicationLog', 'id', 'communication_log_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getReasonsAttribute(){
        $reasons = CommunicationResultReasons::where('communication_results_id',$this->id)->get()->pluck('reason_text')->toArray();
        return implode(',', $reasons);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function task(){
        return $this->hasOne('Edumedics\DataModels\Eloquent\Tasks','id','task_id')->with('assignedTo');
    }

}