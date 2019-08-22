<?php


namespace Edumedics\DataModels\Eloquent;

use Edumedics\DataModels\Aggregate\Appointment;
use Edumedics\DataModels\Aggregate\ClinicalNote;
use Edumedics\DataModels\Aggregate\LabResultView;
use Edumedics\DataModels\Aggregate\PatientSnapshot;
use Edumedics\DataModels\MapTraits\RuleSetTrait;
use Edumedics\DataModels\MapTraits\LabValuesMap;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class RuleSetComponents extends Model
{

    use RuleSetTrait, LabValuesMap;

    /**
     * @var string
     */
    protected $connection = 'pgsql_tenant';

    /**
     * @var string
     */
    public $table = "rule_set_components";

    /**
     * @var array
     */
    public $appends = ['description'];

    /**
     * @var array
     */
    public $fillable = [ 'evaluation_type', 'program_value', 'evaluation_value', 'comparator',
        'comparator_value', 'range_low_value', 'range_high_value', 'time_span' ];

    /**
     * @var
     */
    private $patientSnapshot;

    /**
     * @var array
     */
    protected $FETCH_ROUTINES = [
        '1'   => 'getVitals',
        '2'   => 'getLabResults',
        '3'   => 'getDemographics',
        '3-1' => 'getAge',
        '5-1' => 'getOtherValues',
        '5-2' => 'getOtherValues',
        '6'   => 'getEmVitals'
    ];

    /**
     * @var array
     */
    protected $FETCH_ROUTINE_PARAMS = [
        '2'   => 'getLabParams',
        '2-1' => 'getGlucoseLabParams',
        '2-9' => 'getGlucoseLabParams',
        '5-1' => 'getCOPDParams',
        '5-2' => 'getPHQ9Params'
    ];

    /**
     * @var array
     */
    protected $ASSESSMENT_ROUTINES = [
        '1'   => 'assessProgramEnrollment',
        '2'   => 'assessValueComparison',
        '3'   => 'assessValueRange',
        '5-1' => 'evaluateCOPDValueComparison',
        '5-2' => 'evaluatePHQ9ValueComparison',
        '5-3' => 'evaluateDiagnosis',
        '5-4' => 'evaluateCompletedAppointment',
        '5-5' => 'evaluateCompletedProcedure'
    ];

    /**
     * @return mixed
     */
    public function getFieldNameAttribute()
    {
        return $this->getEvaluationFieldName($this->evaluation_value, !empty(trim($this->time_span)));
    }

    /**
     * @return string
     */
    public function getDescriptionAttribute()
    {
        if ($this->evaluation_type == 1)
        {
            return 'enrolled in ' . $this->getEvaluationValueName($this->program_value);
        }
        elseif ($this->evaluation_type == 2)
        {
            return $this->getEvaluationValueName($this->evaluation_value)
                . ' ' . $this->comparator . ' ' . $this->getComparatorValueName($this->evaluation_value, $this->comparator_value)
                . ($this->time_span ? (' in the past '.$this->time_span) : '');
        }
        elseif ($this->evaluation_type == 3)
        {
            return $this->getEvaluationValueName($this->evaluation_value)
                . ' between ' . $this->range_low_value . ' and ' . $this->range_high_value
                . ($this->time_span ? (' in the past '.$this->time_span) : '');
        }
        return '-- No description available --';
    }

    /**
     * @return mixed
     */
    public function getFetchRoutineAttribute()
    {
        try
        {
            //break down the evaluation value
            $evalCodes = explode("-",$this->evaluation_value);
            //look for a specific routine to use first, then try a more generic one given for first number in evaluation value
            return isset($this->FETCH_ROUTINES[$this->evaluation_value]) ? $this->FETCH_ROUTINES[$this->evaluation_value] :
                (isset($this->FETCH_ROUTINES[$evalCodes[0]]) ? $this->FETCH_ROUTINES[$evalCodes[0]] : null);
        }
        catch(\Exception $e)
        {
            Log::info("Error in retrieving fetch routine for component: " . $e->getMessage());
        }

    }

    /**
     * @return array|mixed
     */
    public function getFetchRoutineParamsAttribute()
    {
        try
        {
            //break down the evaluation values
            $evalCodes = explode("-",$this->evaluation_value);
            //look for a specific routine to use first, then try a more generic one give for first number in evaluation value
            $paramsFunction =  isset($this->FETCH_ROUTINE_PARAMS[$this->evaluation_value]) ? $this->FETCH_ROUTINE_PARAMS[$this->evaluation_value] :
                              (isset($this->FETCH_ROUTINE_PARAMS[$evalCodes[0]]) ? $this->FETCH_ROUTINE_PARAMS[$evalCodes[0]] : null);

            return isset($paramsFunction) ? call_user_func(array($this, $paramsFunction)) : array();
        }
        catch(\Exception $e)
        {
            Log::info("Error in retrieving fetch routine parameters for component: " . $e->getMessage());
        }
    }

    /**
     * @return array
     */
    public function getGlucoseLabParams()
    {
        return array(0=>$this->loinc_to_value_name_glucose_status);
    }

    /**
     * @return array
     */
    public function getLabParams()
    {
        return array(0=>$this->loinc_to_value_name);
    }

    /**
     * @return array
     */
    public function getCOPDParams()
    {
        $stageField = $this->getCopdStageField();
        return array(
            0=>$stageField,
            1=>'copd'
        );
    }

    /**
     * @return array
     */
    public function getPHQ9Params()
    {
        $soughtField = $this->getPHQ9ScoreField();
        return array(
            0=>$soughtField,
            1=>'phq9'
        );
    }

    /**
     * @return mixed
     */
    public function getAssessmentRoutineAttribute()
    {
        try
        {
            //get the assessment routine, try more specific first by evaluation value, then try generic using evaluation type
            return isset($this->ASSESSMENT_ROUTINES[$this->evaluation_value]) ? $this->ASSESSMENT_ROUTINES[$this->evaluation_value] :
                (isset($this->ASSESSMENT_ROUTINES[$this->evaluation_type]) ? $this->ASSESSMENT_ROUTINES[$this->evaluation_type] : null);
        }
        catch(\Exception $e)
        {
            Log::info("Error in retrieving assessment routine for component: " . $e->getMessage());
        }
    }

    /**
     * @return \DateTime|false|null
     * @throws \Exception
     */
    public function getSinceDateAttribute()
    {
        try
        {
            switch($this->time_span)
            {
                case 'Month':
                    return date_add(new \DateTime(), date_interval_create_from_date_string("-1 month"));
                case 'Day':
                    return date_add(new \DateTime(), date_interval_create_from_date_string("-1 day"));
                case 'Year':
                    return date_add(new \DateTime(), date_interval_create_from_date_string("-1 year"));
            }

            return null;
        }
        catch(\Exception $e)
        {
            Log::info("Error in calculating time span for rule set evaluation: " . $e->getMessage());
        }

    }

    /**
     * @return mixed
     */
    public function getValuesToFetchAttribute()
    {
        try
        {
            return call_user_func_array(array($this,$this->fetch_routine), $this->fetch_routine_params);
        }
        catch (\Exception $e)
        {
            Log::info("Error occurred invoking method to retrieve values to assess for component: " . $e->getMessage());
        }

    }

    /**
     * @return array
     */
    protected function getVitals()
    {
        try
        {
            if (empty(trim($this->time_span)))
            {
                return isset($this->patientSnapshot->{$this->field_name}) ? array(0 => $this->patientSnapshot->{$this->field_name}->value) : array();
            }
            return Appointment::with('vitals')->where('patient', $this->patientSnapshot->patient->drchrono_patient_id)
                ->where('scheduled_time', '>=', $this->since_date)->pluck($this->field_name)->toArray();
        }
        catch(\Exception $e)
        {
            Log::info("Error in retrieving vitals values to compare for component evaluation: " . $e->getMessage());
        }

    }

    /**
     * @return array
     */
    protected function getEmVitals()
    {
        try
        {
            if (empty(trim($this->time_span)))
            {
                return isset($this->patientSnapshot->{$this->field_name}) ? array(0 => $this->patientSnapshot->{$this->field_name}->value) : array();
            }
            return EmVitalsAssessmentObservation::where('patient_id', $this->patientSnapshot->patient->_id)
                ->where('observation_received_at', '>=', $this->since_date)->pluck($this->field_name)->toArray();
        }
        catch(\Exception $e)
        {
            Log::info("Error in retrieving emVitals values to compare for component evaluation: " . $e->getMessage());
        }

    }

    /**
     * @param $mapping
     * @return array
     */
    protected function getLabResults($mapping)
    {
        try
        {
            if (empty(trim($this->time_span)))
            {
                return isset($this->patientSnapshot->{$this->field_name}) ? array(0 => $this->patientSnapshot->{$this->field_name}->value) : array();
            }

            $loincs = array_keys($mapping, $this->field_name);
            return LabResultView::where('patient', $this->patientSnapshot->patient->drchrono_patient_id)
                ->whereIn('loinc_code', $loincs)->where('result_date', '>=', $this->since_date)->pluck('value')->toArray();
        }
        catch(\Exception $e)
        {
            Log::info("Error in retrieving lab values to compare for component evaluation: " . $e->getMessage());
        }
    }

    /**
     * @return array
     */
    protected function getDemographics()
    {
        try
        {
            return isset($this->patientSnapshot->patient->{$this->field_name}) ? array(0=>$this->patientSnapshot->patient->{$this->field_name}) : array();
        }
        catch(\Exception $e)
        {
            Log::info("Error in retrieving demographic values to compare for component evaluation: " . $e->getMessage());
        }

    }

    /**
     * @return array
     */
    protected function getAge()
    {
        try
        {
            return isset($this->patientSnapshot->patient->date_of_birth) ? array(0 => $this->ageFromBirthdate($this->patientSnapshot->patient->date_of_birth)) : array();
        }
        catch(\Exception $e)
        {
            Log::info("Error in retrieving age to compare for component evaluation: " . $e->getMessage());
        }
    }

    /**
     * @param $soughtField
     * @param $soughtKey
     * @return array
     */
    protected function getOtherValues($soughtField, $soughtKey)
    {
        try
        {
            if(empty(trim($this->time_span)))
            {
                return isset($this->patientSnapshot->{$this->field_name}) ? array(0=>$this->patientSnapshot->{$this->field_name}->value) : array();
            }
            $sinceDate = $this->since_date;
            $clinicalNotes = ClinicalNote::whereHas('drChronoAppointment', function($q) use ($sinceDate) {
                $q->where('scheduled_time','>=', $sinceDate);
            })->where('patient', $this->patientSnapshot->patient->drchrono_patient_id)->get();

            $returnVals = [];
            foreach($clinicalNotes as $clinicalNote) {
                foreach ($clinicalNote->clinicalNoteSections as $clinicalNoteSection) {
                    if (isset($clinicalNoteSection->name) && stripos($clinicalNoteSection->name, $soughtKey) !== false) {
                        foreach ($clinicalNoteSection->values as $value) {
                            if ($value->clinical_note_field == $soughtField && !empty(trim($value->value)))
                            {
                                array_push($returnVals, $value);
                            }
                        }
                    }
                }
            }
            return $returnVals;
        }
        catch(\Exception $e)
        {
            Log::info("Error in retrieving " . $soughtKey . " to compare for component evaluation: " . $e->getMessage());
        }
    }

    /**
     * @param $patientId
     * @param $evaluationString
     * @return array|mixed
     */
    public function assessComponent($patientId, $evaluationString)
    {
        try
        {
            $this->patientSnapshot = PatientSnapshot::with('patient')->where('patient_id', $patientId)->first();
            if(!isset($this->patientSnapshot))
            {
                Log::info("Unable to evaluate rule set component. Cannot find patient snapshot.");
                return array(false, "Unable to evaluate rule set component. Cannot find patient snapshot.");
            }

            $this->patientSnapshot->loadMissing('patient');
            if(!isset($this->patientSnapshot->patient))
            {
                Log::info("Unable to evaluate rule set component. Cannot find patient.");
                return array(false,"Unable to evaluate rule set component. Cannot find patient.");
            }
            //invoke the routine to assess this component
            return call_user_func_array(array($this,$this->assessment_routine), array($evaluationString));
        }
        catch(\Exception $e)
        {
            Log::info("Error occurred invoking method to assess component: " . $e->getMessage());
        }
    }

    /**
     * @param $evaluationString
     * @return array
     */
    protected function assessProgramEnrollment($evaluationString)
    {
        try
        {
            $programName = $this->getEvaluationValueName($this->program_value);

            $clientProgramIds = ClientsPrograms::active()->where('client_id', $this->patientSnapshot->patient->client_id)
                ->whereHas('program', function($q) use ($programName) {
                    $q->where('program_name', $programName);
                })->pluck('id')->toArray();

            if (isset($clientProgramIds) && !empty($clientProgramIds))
            {
                foreach ($this->patientSnapshot->enrollments as $enrollment)
                {
                    if(!isset($enrollment)) continue; //got to next if enrollment not set

                    if ((!$this->time_span || $enrollment->enrollment_start_date >= $this->since_date)
                        && isset($enrollment->client_program_id) && in_array($enrollment->client_program_id, $clientProgramIds))
                    {
                      return array(true,$this->appendEvaluationText(true, $evaluationString,
                          "patient enrolled on " . $enrollment->enrollment_start_date));
                    }
                }
            }

            return array(false, $this->appendEvaluationText(false, $evaluationString,
                "patient not enrolled as of " . (new \DateTime())->format('Y-m-d H:i:s')));
        }
        catch(\Exception $e)
        {
            Log::info("Error in assessing program enrollment for component evaluation: " . $e->getMessage());
        }

    }

    /**
     * @param $evaluationString
     * @return array
     */
    protected function assessValueRange($evaluationString)
    {
        try
        {
            foreach($this->values_to_fetch as $val)
            {
                $valueToCompare = $this->sanitizeClinicalValue($val);
                if (!empty($valueToCompare) && !ctype_space($valueToCompare) && preg_match("/[0-9]/", $valueToCompare))
                {
                    if(($valueToCompare >= $this->range_low_value) && ($valueToCompare <= $this->range_high_value))
                    {
                        return array(true,$this->appendEvaluationText(true, $evaluationString,
                            "value found: " . $valueToCompare));
                    }
                }
            }

            return array(false,$this->appendEvaluationText(false, $evaluationString,
                "no values in range as of " . (new \DateTime())->format('Y-m-d H:i:s')));
        }
        catch(\Exception $e)
        {
            Log::info("Error in assessing value range for component evaluation: " . $e->getMessage());
        }

    }

    /**
     * @param $evaluationString
     * @return array
     */
    protected function assessValueComparison($evaluationString)
    {
        try
        {
            foreach ($this->values_to_fetch as $val)
            {
                $valueToCompare = $this->sanitizeClinicalValue($val);
                if (!empty($valueToCompare) && !ctype_space($valueToCompare) && preg_match("/[0-9]/", $valueToCompare)) {
                    if (version_compare($valueToCompare, $this->comparator_value, $this->comparator))
                    {
                        return array(true,$this->appendEvaluationText(true, $evaluationString,
                            "value found: " . $valueToCompare));
                    }
                }
            }

            return array(false,$this->appendEvaluationText(false, $evaluationString,
                "no matching values as of " . (new \DateTime())->format('Y-m-d H:i:s')));
        }
        catch(\Exception $e)
        {
            Log::info("Error in assessing value comparison for component evaluation: " . $e->getMessage());
        }

    }

    /**
     * @param $evaluationString
     * @return array
     */
    protected function evaluateCOPDValueComparison($evaluationString)
    {
        try
        {
            foreach($this->values_to_fetch as $patientValue)
            {
                if ($this->comparator_value == 1)
                {
                    $eval = stripos($patientValue, 'Stage I') !== false && !stripos($patientValue, 'Stage II') &&
                        !stripos($patientValue, 'Stage III') && !stripos($patientValue, 'Stage IV');
                }
                elseif ($this->comparator_value == 2)
                {
                    $eval = stripos($patientValue, 'Stage II') !== false && !stripos($patientValue, 'Stage III');
                }
                elseif ($this->comparator_value == 3)
                {
                    $eval =  stripos($patientValue, 'Stage III') !== false;
                }
                elseif ($this->comparator_value == 4)
                {
                    $eval = stripos($patientValue, 'Stage IV') !== false;
                }
                if(isset($eval))
                {
                    return array($eval,$this->appendEvaluationText($eval, $evaluationString, "COPD value: " . $patientValue));
                }
            }

            return array(false, $this->appendEvaluationText(false,$evaluationString,
                "no matching COPD value found as of " . (new \DateTime())->format('Y-m-d H:i:s')));
        }
        catch(\Exception $e)
        {
            Log::info("Error in assessing COPD value comparison for component evaluation: " . $e->getMessage());
        }

    }

    /**
     * @param $evaluationString
     * @return array
     */
    protected function evaluatePHQ9ValueComparison($evaluationString)
    {
        try
        {
            foreach($this->values_to_fetch as $patientValue)
            {
                $unescapedValue = str_replace(['&lt;', '&gt;'], ['<', '>'], $patientValue);

                if(in_array($this->comparator_value, $this->phq9RangesEvalMap))
                {
                    $eval = stripos($unescapedValue, $this->phq9RangesEvalMap[$this->comparator_value]) !== false;
                }
                if(isset($eval))
                {
                    return array($eval, $this->appendEvaluationText($eval,$evaluationString, "PHQ9 value: " . $unescapedValue));
                }
            }

            return array(false, $this->appendEvaluationText(false,$evaluationString,
                "no matching PHQ9 value found as of " . (new \DateTime())->format('Y-m-d H:i:s')));
        }
        catch(\Exception $e)
        {
            Log::info("Error in assessing PHQ9 score value comparison for component evaluation: " . $e->getMessage());
        }

    }

    /**
     * @param $evaluationString
     * @return array|bool
     */
    protected function evaluateDiagnosis($evaluationString)
    {
        try
        {
            $icd10_codes = DiagnosisDefinitions::where('id',$this->comparator_value)->pluck('codes')->first();
            if(!isset($icd10_codes)) return false;

            if(empty(trim($this->time_span)))
            {
                $hasDx = PatientDiagnoses::where('patient_id',$this->patientSnapshot->patient_id)
                    ->whereIn('icd10_code', $icd10_codes)->first();
            }
            else
            {
                $hasDx = PatientDiagnoses::where('patient_id',$this->patientSnapshot->patient_id)
                    ->whereIn('icd10_code', $icd10_codes)
                    ->where('updated_at','>=',$this->since_date)->first();
            }

            return array(isset($hasDx), $this->appendEvaluationText(isset($hasDx), $evaluationString,
                "as of " . (new \DateTime())->format('Y-m-d H:i:s')));
        }
        catch(\Exception $e)
        {
            Log::info("Error in assessing diagnosis for component evaluation: " . $e->getMessage());
        }

    }

    /**
     * @param $evaluationString
     * @return array
     */
    protected function evaluateCompletedAppointment($evaluationString)
    {
        try
        {
            if(empty(trim($this->time_span)))
            {
                $hasAppt = Appointment::where([
                    'patient'=>$this->patientSnapshot->patient->drchrono_patient_id,
                    'profile'=>$this->comparator_value,
                    'status'=>'Complete'
                ])->first();
            }
            else
            {
                $hasAppt = Appointment::where([
                    'patient'=>$this->patientSnapshot->patient->drchrono_patient_id,
                    'profile'=>$this->comparator_value,
                    'status'=>'Complete'
                ])->
                where('scheduled_time', '>=', $this->since_date)->first();
            }

            return array(isset($hasAppt), $this->appendEvaluationText(isset($hasAppt), $evaluationString,
                "as of " . (new \DateTime())->format('Y-m-d H:i:s')));
        }
        catch(\Exception $e)
        {
            Log::info("Error in assessing completed appointment for component evaluation: " . $e->getMessage());
        }

    }

    /**
     * @param $evaluationString
     * @return array
     */
    protected function evaluateCompletedProcedure($evaluationString)
    {
        Log::info($this->description . " evaluated to false. Completed procedure given is: " . $this->comparator_value);
        //TODO waiting on CPT code implementation
        return array(false, $this->appendEvaluationText(false,$evaluationString,
            "Rule set evaluation not yet implemented for completed procedures."));
    }

    /**
     * @param $eval
     * @param $evaluationString
     * @param $appending
     * @return string
     */
    protected function appendEvaluationText($eval, $evaluationString, $appending)
    {
        if(!empty($evaluationString))
        {
            $evaluationString = $evaluationString . ", ";
        }
        $evaluation = $eval ? "->evaluated to true->" : "->evaluated to false->";
        return $evaluationString . $this->description . $evaluation . $appending;
    }
}