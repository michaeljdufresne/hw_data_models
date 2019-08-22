<?php


namespace Edumedics\DataModels\Eloquent;


use Illuminate\Database\Eloquent\Model;

class ClinicalCarePlans extends Model
{

    /**
     * @var string
     */
    protected $connection = 'pgsql_tenant';

    /**
     * @var string
     */
    public $table = "clinical_care_plans";

    /**
     * @var array
     */
    public static $planDiagnosticActions = [
        0 => 'Blood Pressure',
        1 => 'BMI',
        2 => 'LDL',
        3 => 'Triglycerides',
        4 => 'A1c',
        5 => 'Appointment',
        6 => 'eGFR',
        7 => 'emVitals Assessment'
    ];

    /**
     * @var array
     */
    public static $PlanDiagnosticActionNames = [
        'Blood Pressure' => 0,
        'BMI' => 1,
        'LDL' => 2,
        'Triglycerides' => 3,
        'A1c' => 4,
        'Appointment' => 5,
        'eGFR' => 6,
        'emVitals Assessment' => 7
    ];

    /**
     * @var array
     */
    public static $PlanDiagnosticActionToSnapshotValue = [
        0 => 'systolic',
        1 => 'bmi',
        2 => 'ldl',
        3 => 'triglycerides',
        4 => 'a1c',
        5 => 'most_recent_appointment',
        6 => 'egfr',
        7 => ['emv_phq8score', 'emv_gad7score', 'emv_pclc6score', 'emv_auditcscore', 'emv_soduscore', 'emv_pss4score',
              'emv_oslo3score', 'emv_sdoh4', 'emv_sdoh5', 'emv_sdoh6', 'emv_phq3', 'emv_sf21', 'emv_cc1']
    ];

    /**
     * @var array
     */
    public static $actionFrequencyMeasurements = [
        0 => 'week',
        1 => 'month',
        2 => 'year'
    ];

    /**
     * @var array
     */
    public $appends = ['description', 'snapshotValueName'];

    /**
     * @var array
     */
    public $fillable = [ 'plan_diagnostic_action', 'action_frequency', 'action_frequency_measurement', 'is_active', 'priority' ];

    /**
     * @param $query
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    /**
     * @param $query
     * @return mixed
     */
    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    /**
     *
     */
    public function activate()
    {
        $this->is_active = true;
        $this->save();
    }

    /**
     *
     */
    public function inactivate()
    {
        $this->is_active = false;
        $this->save();
    }

    /**
     * @return string
     */
    public function getDescriptionAttribute()
    {
        return ClinicalCarePlans::$planDiagnosticActions[$this->plan_diagnostic_action] .
            ' every ' . $this->action_frequency . ' ' .
            ClinicalCarePlans::$actionFrequencyMeasurements[$this->action_frequency_measurement] . '(s)';
    }

    /**
     * @return mixed
     */
    public function getSnapshotValueNameAttribute()
    {
        return ClinicalCarePlans::$PlanDiagnosticActionToSnapshotValue[$this->plan_diagnostic_action];
    }


}