<?php

namespace Edumedics\DataModels\Eloquent;

use Edumedics\DataModels\Aggregate\Appointment;
use Edumedics\DataModels\Aggregate\Patient;
use Edumedics\DataModels\Aggregate\PatientSnapshot;
use Edumedics\DataModels\Events\PatientRiskProfile\PatientRiskProfileCreate;
use Edumedics\DataModels\Events\PatientRiskProfile\PatientRiskProfileDelete;
use Edumedics\DataModels\Events\PatientRiskProfile\PatientRiskProfileUpdate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PatientRiskProfile extends Model
{
    use Notifiable;

    const
        LOW_RISK = 1,
        MEDIUM_RISK = 2,
        HIGH_RISK = 3;

    /**
     * @var string
     */
    protected $connection = 'pgsql_tenant';
    /**
     * @var string
     */
    protected $table = 'patient_biometric_risk_profile';

    /**
     * @var array
     */
    protected $fillable = [
        'bmi', 'bmi_origin', 'total_cholesterol', 'total_cholesterol_origin', 'hdl_male', 'hdl_male_origin', 'hdl_female',
        'hdl_female_origin', 'triglycerides', 'triglycerides_origin', 'ldl', 'ldl_origin', 'tc_hdl_ratio', 'tc_hdl_ratio_origin',
        'glucose', 'glucose_origin', 'a1c', 'a1c_origin', 'systolic_bp', 'systolic_bp_origin', 'diastolic_bp', 'diastolic_bp_origin',
        'waist_male', 'waist_male_origin', 'waist_female', 'waist_female_origin', 'emv_phq8score', 'emv_phq8score_origin',
        'emv_gad7score', 'emv_gad7score_origin', 'emv_pclc6score', 'emv_pclc6score_origin', 'emv_auditcscore', 'emv_auditcscore_origin'
    ];

    /**
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => PatientRiskProfileCreate::class,
        'updated' => PatientRiskProfileUpdate::class,
        'deleting' => PatientRiskProfileDelete::class
    ];

    /**
     * @var array
     */
    public static $RiskScoreToWordMapping = [
        1 => "Low",
        2 => "Medium",
        3 => "High"
    ];

    /**
     * @var array
     */
    public static $VitalsNamesMapping = [
        'bmi' => 'bmi',
        'systolic_bp' => 'blood_pressure_1',
        'diastolic_bp' => 'blood_pressure_2',
        'waist_male' => 'waist_circumference',
        'waist_female' => 'waist_circumference'
    ];

    public static $EmVitalsNameMapping = [
        'emv_phq8score' => 'emv_phq8score',
        'emv_gad7score' => 'emv_gad7score',
        'emv_pclc6score' => 'emv_pclc6score',
        'emv_auditcscore' => 'emv_auditcscore'
    ];

    /**
     * @var array
     */
    public static $Origins = [
        'bmi_origin', 'total_cholesterol_origin', 'hdl_male_origin', 'hdl_female_origin', 'triglycerides_origin', 'ldl_origin',
        'tc_hdl_ratio_origin', 'glucose_origin', 'a1c_origin', 'systolic_bp_origin', 'diastolic_bp_origin', 'waist_male_origin',
        'waist_female_origin', 'emv_phq8score_origin', 'emv_gad7score_origin', 'emv_pclc6score_origin', 'emv_auditcscore_origin'
    ];

    /**
     * @var array
     */
    public static $Values = [
        'bmi', 'total_cholesterol', 'hdl_male', 'hdl_female', 'triglycerides', 'ldl', 'tc_hdl_ratio', 'glucose', 'a1c', 'systolic_bp',
        'diastolic_bp', 'waist_male', 'waist_female', 'emv_phq8score', 'emv_gad7score', 'emv_pclc6score', 'emv_auditcscore'
    ];

    public static $PDValues = [
        'bmi', 'total_cholesterol', 'hdl_male', 'hdl_female', 'triglycerides', 'ldl', 'tc_hdl_ratio', 'glucose', 'a1c', 'systolic_bp',
        'diastolic_bp', 'waist_male', 'waist_female'
    ];

    /**
     * @var array
     */
    public static $RangeNames = [
        'bmiRange', 'tcRange', 'hdlMaleRange', 'hdlFemaleRange', 'triglyceridesRange', 'ldlRange', 'tcHdlRatioRange',
        'glucoseRange', 'a1cRange', 'systolicBpRange', 'diastolicBpRange', 'waistMaleRange', 'waistFemaleRange',
        'emvphq8ScoreRange', 'emvgad7ScoreRange', 'emvpclc6ScoreRange', 'emvAuditCScoreRange'
    ];

    /**
     * @var array
     */
    public static $PDValueNames = [
        'bmiPreDiabeticValue', 'tcPreDiabeticValue', 'hdlMalePreDiabeticValue', 'hdlFemalePreDiabeticValue',
        'triglyceridesPreDiabeticValue', 'ldlPreDiabeticValue', 'tcHdlRatioPreDiabeticValue', 'glucosePreDiabeticValue',
        'a1cPreDiabeticValue', 'systolicPreDiabeticValue', 'diastolicPreDiabeticValue', 'waistMalePreDiabeticValue',
        'waistFemalePreDiabeticValue'
    ];

    /**
     * @var array
     */
    public static $OriginNames = ['bmiOrigin', 'totalCholesterolOrigin', 'hdlMaleOrigin', 'hdlFemaleOrigin',
        'triglyceridesOrigin', 'ldlOrigin', 'tcHdlRatioOrigin', 'glucoseOrigin', 'a1cOrigin',
        'systolicBpOrigin', 'diastolicBpOrigin', 'waistMaleOrigin', 'waistFemaleOrigin', 'emvphq8ScoreOrigin',
        'emvgad7ScoreOrigin', 'emvpclc6ScoreOrigin', 'emvAuditCScoreOrigin'];

    /**
     * @return array
     */
    public static function OriginsToValues()
    {
        return array_combine(PatientRiskProfile::$Origins, PatientRiskProfile::$Values);
    }

    /**
     * @return array
     */
    public static function RangeNamesToValues()
    {
        return array_combine(PatientRiskProfile::$RangeNames, PatientRiskProfile::$Values);
    }

    /**
     * @return array
     */
    public static function PDValueNamesToValue()
    {
        return array_combine(PatientRiskProfile::$PDValueNames, PatientRiskProfile::$PDValues);
    }

    /**
     * @param array $options
     * @return bool
     */
    public function save(array $options = [])
    {
        $this->evaluateTcHdlRatio();
        return parent::save($options);
    }

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

    /**
     * @param $query
     * @return mixed
     */
    public function scopeWithAllOrigins($query)
    {
        return $query->with(PatientRiskProfile::$OriginNames);
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
     *
     */
    public function activate()
    {
        $this->is_active = true;
        $this->save();
    }

    /**
     * @param $originsMap
     * @return bool
     */
    public function hasChanged($originsMap)
    {
        foreach ($originsMap as $originKey => $originObjectId)
        {
            if ($originKey == 'tc_hdl_ratio_origin') continue;
            if ($this->{$originKey} != $originObjectId)
            {
                return true;
            }
        }
        return false;
    }

    /**
     * @return array
     */
    public function getValueSourceKeys()
    {
        $arr = [];
        foreach (PatientRiskProfile::$Origins as $originKey)
        {
            $arr[] = $this->{$originKey};
        }
        return array_unique($arr);
    }

    /**
     * @return mixed
     */
    public function getHdl()
    {
        if (!empty($this->hdl_male))
        {
            return $this->hdl_male;
        }
        return $this->hdl_female;
    }

    /**
     * @return array|mixed
     */
    public function getOriginalHdl()
    {
        if (!empty($this->getOriginal('hdl_male')))
        {
            return $this->getOriginal('hdl_male');
        }
        return $this->getOriginal('hdl_female');
    }

    /**
     * @param $sourceObject
     */
    public function updateProfile($sourceObject)
    {
        if ($sourceObject instanceof Appointment)
        {
            foreach ($this->OriginsToValues() as $originName => $valueName)
            {
                if ($valueName == 'tc_hdl_ratio') continue;
                if ($this->{$originName} == $sourceObject->_id)
                {
                    $this->{$valueName} = $sourceObject->vitals->{PatientRiskProfile::$VitalsNamesMapping[$valueName]};
                }
            }
        }
        else
        {
            foreach ($this->OriginsToValues() as $originName => $valueName)
            {
                if ($valueName == 'tc_hdl_ratio') continue;
                if ($this->{$originName} == $sourceObject->_id)
                {
                    $this->{$valueName} = $sourceObject->value;
                }
            }
        }
        $this->save();
    }

    /**
     *
     */
    public function calculateRiskScore()
    {
        $this->fresh();
        $this->risk_score = 0;
        $activeRiskProfile = RiskProfileDefinitions::active()->withAllRanges()->first();
        $patient = Patient::find($this->patient_id);

        if (isset($activeRiskProfile) && isset($patient))
        {
            $this->risk_profile_definition_id = $activeRiskProfile->id;
            $outOfRangeValues = 0;
            $dangerValues = 0;
            $isPreDiabetic = false;
            foreach ($this->RangeNamesToValues() as $riskRangeId => $riskValue)
            {
                if (isset($this->{$riskValue}))
                {
                    $range = $activeRiskProfile->{$riskRangeId};
                    if (isset($range))
                    {
                        if ($this->stripToNumeric($this->{$riskValue}) >= $range->abnormal_low_value &&
                            $this->stripToNumeric($this->{$riskValue}) <= $range->abnormal_high_value)
                        {
                            $outOfRangeValues++;
                        }
                        elseif ($this->compare($this->stripToNumeric($this->{$riskValue}), $range->danger_comparator, $range->danger_value))
                        {
                            $dangerValues++;
                        }
                    }
                }
            }
            foreach ($this->PDValueNamesToValue() as $pdValueId => $value)
            {
                $pdValue = $activeRiskProfile->{$pdValueId};
                if (isset($pdValue))
                {
                    if (isset($pdValue) && isset($this->{$value}))
                    {
                        if ($this->compare($this->stripToNumeric($this->{$riskValue}), $pdValue->comparator, $pdValue->value))
                        {
                            $isPreDiabetic = true;
                        }
                        else
                        {
                            $isPreDiabetic = false;
                            break;
                        }
                    }
                }
            }
            if ($isPreDiabetic)
            {
                $this->handlePreDiabeticPatient($patient);
            }
            $this->risk_score = $this->determineRiskScore($outOfRangeValues, $dangerValues);

            if($this->risk_score == 3)
            {
                // Check if client has Health Coaching program
                $clientHasHealthCoaching = $this->checkClientHealthCoachingProgram($patient);
                if($clientHasHealthCoaching)
                {
                    // Check for Chronic Condition & HealthCoaching Eligibility/Enrollment
                    if(!$this->patientHasChronicCondition($patient)
                        && !$this->patientHasHealthCoachingStatus($patient))
                    {
                        // Create HealthCoaching Eligibility
                        $this->handleHealthCoachingEligibility($patient);
                    }
                }
            }
        }
        $this->save();
    }


    /**
     * @param $patient
     * @return bool
     */
    protected function checkClientHealthCoachingProgram($patient)
    {
        return ClientsPrograms::active()->where('client_id', $patient->client_id)
                ->whereHas('program', function($q) {
                    $q->where('program_name','Health Coaching');
                })->count() > 0;
    }

    /**
     * @param $patient
     * @throws \Exception
     */
    protected function handleHealthCoachingEligibility($patient)
    {
        $clientProgram = ClientsPrograms::active()->where('client_id', $patient->client_id)
            ->whereHas('program', function($q) {
                $q->where('program_name','Health Coaching');
            })->first();

        if (isset($clientProgram))
        {
            $newEligibility = new ParticipantProgramEligibility();
            $newEligibility->patient_id = $patient->_id;
            $newEligibility->client_program_id = $clientProgram->id;
            $newEligibility->eligibility_start_date = new \DateTime();
            $newEligibility->eligibility_origin = 3;
            $newEligibility->is_active = true;
            $newEligibility->save();

            $this->handleProgramEligibilitySuperseding($clientProgram->id, $patient);
        }
    }

    /**
     * @param $patient
     * @return bool
     */
    protected function patientHasHealthCoachingStatus($patient)
    {
        $eligibility = ParticipantProgramEligibility::active()
            ->where('patient_id', $patient->_id)->whereHas('clientProgram', function ($query) {
                $query->whereHas('program', function($q) {
                    $q->where('program_name','Health Coaching');
                });
            })->count();

        $enrollment = ParticipantProgramEnrollment::active()
            ->where('patient_id', $patient->_id)->whereHas('clientProgram', function ($query) {
                $query->whereHas('program', function($q) {
                    $q->where('program_name','Health Coaching');
                });
            })->count();

        return ($eligibility > 0 || $enrollment > 0);
    }

    /**
     * @param $patient
     * @return bool
     */
    protected function patientHasChronicCondition($patient)
    {
        $eligibilities = ParticipantProgramEligibility::active()
            ->where('patient_id', $patient->_id)->whereHas('clientProgram', function($q) {
                $q->whereIn('program_id',  Program::getChronicConditionProgramIds());
            })->count();

        $enrollments = ParticipantProgramEnrollment::active()
            ->where('patient_id', $patient->_id)->whereHas('clientProgram', function($q) {
                $q->whereIn('program_id',  Program::getChronicConditionProgramIds());
            })->count();

        return ($eligibilities > 0 || $enrollments > 0);
    }

    /**
     * @param $patient
     * @throws \Exception
     */
    protected function handlePreDiabeticPatient($patient)
    {
        $clientProgram = ClientsPrograms::where('client_id', $patient->client_id)
            ->whereHas('program', function($q) {
                $q->where('program_name','Diabetes');
            })->active()->first();

        if(isset($clientProgram))
        {
            $eligibility = ParticipantProgramEligibility::active()
                ->where(['patient_id' => $patient->_id, 'client_program_id' => $clientProgram->id])->first();

            $enrollment = ParticipantProgramEnrollment::active()
                ->where(['patient_id' => $patient->_id, 'client_program_id' => $clientProgram->id])->first();

            if (!isset($eligibility))
            {
                $newEligibility = new ParticipantProgramEligibility();
                $newEligibility->patient_id = $patient->_id;
                $newEligibility->client_program_id = $clientProgram->id;
                $newEligibility->eligibility_start_date = new \DateTime();
                $newEligibility->eligibility_origin = 3;
                $newEligibility->is_active = true;
                $newEligibility->save();

                $this->handleProgramEligibilitySuperseding($clientProgram->id, $patient);
            }

            if (!isset($enrollment))
            {
                $patientSnapshot = PatientSnapshot::where('patient_id', $patient->_id)->first();
                $patientSnapshot->is_prediabetic = true;
                $patientSnapshot->save();
            }
        }
    }

    public function handleProgramEligibilitySuperseding($program_id, $patient)
    {
        $clientProgramSuperseding = ProgramSuperseding::where('parent_program_id',$program_id)->get();
        foreach ($clientProgramSuperseding as $programSuperseding){
            // Get the clientProgram relationship id of this child program if exists
            $childClientProgram = ClientsPrograms::where('client_id',$patient->client_id)
                ->where('program_id',$programSuperseding->child_program_id)->first();
            if(isset($childClientProgram))
            {
                switch($programSuperseding->action)
                {
                    case 1:
                        // We need to end this child program eligibility if exists no matter the origin but we leave the enrollment
                        $childProgramEligibility = ParticipantProgramEligibility::where('patient_id', $patient->_id)
                            ->where('client_program_id', $childClientProgram->id)->where('is_active', true)->first();
                        if(isset($childProgramEligibility))
                        {
                            $childProgramEligibility->eligibility_end_date = new \DateTime();
                            $childProgramEligibility->is_active = false;
                            $childProgramEligibility->save();
                        }
                        break;

                    case 2:
                        // we need to start this child program eligibility if it doesn't exist
                        $childProgramEligibility = ParticipantProgramEligibility::where('patient_id', $patient->_id)
                            ->where('client_program_id', $childClientProgram->id)->where('is_active', true)->first();
                        if(!isset($childProgramEligibility))
                        {
                            $patientProgramEligibility = new ParticipantProgramEligibility();
                            $patientProgramEligibility->patient_id = $patient->_id;
                            $patientProgramEligibility->client_program_id = $childClientProgram->id;
                            $patientProgramEligibility->eligibility_start_date = new \DateTime();
                            $patientProgramEligibility->eligibility_origin = 4; // Eligibility Rule Set
                            $patientProgramEligibility->save();
                        }
                        break;
                }
            }
        }
    }

    /**
     *
     */
    protected function evaluateTcHdlRatio()
    {
        if (empty($this->total_cholesterol) || empty($this->getHdl())) return;
        if ($this->total_cholesterol == 0 || $this->getHdl() == 0) return;

        if ($this->tcOrHdlHaveChanged())
        {
            $this->tc_hdl_ratio = round($this->total_cholesterol / $this->getHdl(), 1);;
            $this->tc_hdl_ratio_origin = $this->total_cholesterol_origin;
        }
    }

    /**
     * @return bool
     */
    protected function tcOrHdlHaveChanged()
    {
        if ($this->total_cholesterol != $this->getOriginal('total_cholesterol') ||
            $this->getHdl() != $this->getOriginalHdl())
        {
            return true;
        }
        return false;
    }

    /**
     * @param $outOfRangeValues
     * @param $dangerValues
     * @return int
     */
    protected function determineRiskScore($outOfRangeValues, $dangerValues)
    {
        if ($dangerValues >= 1 || $outOfRangeValues >= 3)
        {
            return PatientRiskProfile::HIGH_RISK;
        }
        if ($outOfRangeValues == 2)
        {
            return PatientRiskProfile::MEDIUM_RISK;
        }
        return PatientRiskProfile::LOW_RISK;
    }

    /**
     * @param $value
     * @param $comparator
     * @param $dangerValue
     * @return bool
     */
    protected function compare($value, $comparator, $dangerValue)
    {
        switch ($comparator)
        {
            case '<':
                return $value < $dangerValue;
                break;

            case '<=':
                return $value <= $dangerValue;
                break;

            case '>':
                return $value > $dangerValue;
                break;

            case '>=':
                return $value >= $dangerValue;
                break;

            default:
                return false;
        }
    }

    /**
     * @param $value
     * @return null|string|string[]
     */
    protected function stripToNumeric($value)
    {
        return preg_replace("/[^0-9.]/", "", $value);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function drchrono_patient()
    {
        return $this->hasOne('Edumedics\DataModels\Aggregate\Patient', '_id', 'patient_id');
    }

    // Origin Relationships

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function bmiOrigin()
    {
        return $this->hasOne('Edumedics\DataModels\Aggregate\Appointment', '_id', 'bmi_origin');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function totalCholesterolOrigin()
    {
        return $this->hasOne('Edumedics\DataModels\Aggregate\LabResultView', '_id', 'total_cholesterol_origin');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function hdlMaleOrigin()
    {
        return $this->hasOne('Edumedics\DataModels\Aggregate\LabResultView', '_id', 'hdl_male_origin');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function hdlFemaleOrigin()
    {
        return $this->hasOne('Edumedics\DataModels\Aggregate\LabResultView', '_id', 'hdl_female_origin');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function triglyceridesOrigin()
    {
        return $this->hasOne('Edumedics\DataModels\Aggregate\LabResultView', '_id', 'triglycerides_origin');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function ldlOrigin()
    {
        return $this->hasOne('Edumedics\DataModels\Aggregate\LabResultView', '_id', 'ldl_origin');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function tcHdlRatioOrigin()
    {
        return $this->hasOne('Edumedics\DataModels\Aggregate\LabResultView', '_id', 'tc_hdl_ratio_origin');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function glucoseOrigin()
    {
        return $this->hasOne('Edumedics\DataModels\Aggregate\LabResultView', '_id', 'glucose_origin');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function a1cOrigin()
    {
        return $this->hasOne('Edumedics\DataModels\Aggregate\LabResultView', '_id', 'a1c_origin');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function systolicBpOrigin()
    {
        return $this->hasOne('Edumedics\DataModels\Aggregate\Appointment', '_id', 'systolic_bp_origin');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function diastolicBpOrigin()
    {
        return $this->hasOne('Edumedics\DataModels\Aggregate\Appointment', '_id', 'diastolic_bp_origin');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function waistMaleOrigin()
    {
        return $this->hasOne('Edumedics\DataModels\Aggregate\Appointment', '_id', 'waist_male_origin');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function waistFemaleOrigin()
    {
        return $this->hasOne('Edumedics\DataModels\Aggregate\Appointment', '_id', 'waist_female_origin');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function emvphq8ScoreOrigin()
    {
        return $this->hasOne('Edumedics\DataModels\Eloquent\EmVitalsAssessmentObservation', 'id', 'emv_phq8score_origin');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function emvgad7ScoreOrigin()
    {
        return $this->hasOne('Edumedics\DataModels\Eloquent\EmVitalsAssessmentObservation', 'id', 'emv_gad7score_origin');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function emvpclc6ScoreOrigin()
    {
        return $this->hasOne('Edumedics\DataModels\Eloquent\EmVitalsAssessmentObservation', 'id', 'emv_pclc6score_origin');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function emvAuditCScoreOrigin()
    {
        return $this->hasOne('Edumedics\DataModels\Eloquent\EmVitalsAssessmentObservation', 'id', 'emv_auditcscore_origin');
    }
}