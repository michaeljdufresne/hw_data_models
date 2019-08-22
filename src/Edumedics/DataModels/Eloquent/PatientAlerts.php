<?php


namespace Edumedics\DataModels\Eloquent;


use Edumedics\DataModels\MapTraits\RuleSetTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PatientAlerts extends Model
{

    use Notifiable, RuleSetTrait;

    /**
     * @var string
     */
    protected $connection = 'pgsql_tenant';
    /**
     * @var string
     */
    protected $table = 'patient_alerts';

    /**
     * @var array
     */
    protected $dates = [ 'alert_date' ];

    /**
     * @var array
     */
    protected $appends = [ 'needs_assessment' ];

    /**
     * @var array
     */
    public static $alertTypes = [
        1 => 'Care Plan Expiration',
        2 => 'Critical Value'
    ];

    /**
     * @param $query
     * @param null $patientId
     * @return mixed
     */
    public function scopeActive($query, $patientId = null)
    {
        if (!is_null($patientId))
        {
            return $query->where(['is_active' => true, 'patient_id' => $patientId]);
        }
        return $query->where('is_active', true);
    }

    public function getNeedsAssessmentAttribute(){
        if($this->alert_type == 1){
            $is_EmVitalsAssessmentCarePlan = PatientCarePlans::where('id',$this->patient_care_plan_id)
                ->whereHas('clinical_care_plan', function ($query){
                    $query->where('plan_diagnostic_action',7);
                })->first();
            if(isset($is_EmVitalsAssessmentCarePlan)){
                return true;
            }
            return false;
        }
        return false;
    }

    /**
     * @param $query
     * @param null $patientId
     * @return mixed
     */
    public function scopeInactive($query, $patientId = null)
    {
        if (!is_null($patientId))
        {
            return $query->where(['is_active' => false, 'patient_id' => $patientId]);
        }
        return $query->where('is_active', false);
    }

    /**
     *
     */
    public function expire()
    {
        $this->is_active = false;
        $this->save();
    }

    /**
     * @return array
     */
    public static function getCriticalValueSourceTypes()
    {
        return self::$VITALS_EVAL_VALUES + self::$LAB_EVAL_VALUES;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function drchrono_patient()
    {
        return $this->hasOne('Edumedics\DataModels\Aggregate\Patient', '_id', 'patient_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function patient_care_plan()
    {
        return $this->hasOne('Edumedics\DataModels\Eloquent\PatientCarePlans', 'id', 'patient_care_plan_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function clinical_critical_value()
    {
        return $this->hasOne('Edumedics\DataModels\Eloquent\ClinicalCriticalValues', 'id', 'critical_value_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function task()
    {
        return $this->hasOne('Edumedics\DataModels\Eloquent\Tasks', 'id', 'task_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function care_plan_value_expiration()
    {
        return $this->belongsTo('Edumedics\DataModels\Eloquent\PatientCarePlanValueExpiration', 'patient_care_plan_value_expiration_id', 'id');
    }

}