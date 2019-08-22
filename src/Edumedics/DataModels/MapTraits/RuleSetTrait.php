<?php


namespace Edumedics\DataModels\MapTraits;


use Edumedics\DataModels\Aggregate\AppointmentProfile;
use Edumedics\DataModels\Eloquent\Client;
use Edumedics\DataModels\Eloquent\DiagnosisDefinitions;
use Edumedics\DataModels\Eloquent\ProcedureDefinitions;
use Edumedics\DataModels\Eloquent\RuleSetComponents;

trait RuleSetTrait
{

    /**
     * @var array
     */
    protected static $VITALS_EVAL_VALUES = [
        '1-1' => 'Systolic Blood Pressure',
        '1-2' => 'Diastolic Blood Pressure',
        '1-3' => 'BMI'
    ];

    /**
     * @var array
     */
    protected static $VITALS_EVAL_FIELDS = [
        '1-1-historical' => 'blood_pressure_1',
        '1-1' => 'systolic',
        '1-2-historical' => 'blood_pressure_2',
        '1-2' => 'diastolic',
        '1-3' => 'bmi'
    ];

    /**
     * @var array
     */
    protected static $LAB_EVAL_VALUES = [
        '2-1' => 'Fasting Glucose',
        '2-2' => 'Total Cholesterol',
        '2-3' => 'LDL',
        '2-4' => 'Triglycerides',
        '2-5' => 'A1c',
        '2-6' => 'Serum Creatinine',
        '2-7' => 'BUN',
        '2-8' => 'eGFR',
        '2-9' => 'Non-Fasting Glucose'
    ];

    /**
     * @var array
     */
    protected static $LAB_EVAL_FIELDS = [
        '2-1' => 'glucose_fasting',
        '2-2' => 'total_cholesterol',
        '2-3' => 'ldl',
        '2-4' => 'triglycerides',
        '2-5' => 'a1c',
        '2-6' => 'creatinine',
        '2-7' => 'bun',
        '2-8' => 'egfr',
        '2-9' => 'glucose_non_fasting'
    ];

    /**
     * @var array
     */
    protected static $DEMOGRAPHIC_EVAL_VALUES = [
        '3-1' => 'Age',
        '3-2' => 'Gender',
        '3-3' => 'Client',
        '3-4' => 'Employee Type',
        '3-5' => 'State',
        '3-6' => 'Race'
    ];

    /**
     * @var array
     */
    protected static $DEMOGRAPHIC_EVAL_FIELDS = [
        '3-1' => 'date_of_birth',
        '3-2' => 'gender',
        '3-3' => 'client_id',
        '3-4' => 'type',
        '3-5' => 'state',
        '3-6' => 'race'
    ];

    /**
     * @var array
     */
    protected static $PROGRAM_EVAL_VALUES = [
        '4-1' => 'Hypertension',
        '4-2' => 'Hyperlipidemia',
        '4-3' => 'Diabetes',
        '4-4' => 'Depression',
        '4-5' => 'COPD',
        '4-6' => 'Health Coaching',
        '4-7' => 'Chronic Kidney Disease'
    ];

    /**
     * @var array
     */
    protected static $OTHER_EVAL_VALUES = [
        '5-1' => 'COPD Stage',
        '5-2' => 'PHQ9 Score',
        '5-3' => 'Diagnosis',
        '5-4' => 'Completed Appointment',
        '5-5' => 'Procedure'
    ];

    /**
     * @var array
     */
    protected static $OTHER_EVAL_FIELDS = [
        '5-1' => 'copd_stage',
        '5-2' => 'phq9_score',
        '5-3' => 'diagnosis',
        '5-4' => 'completed_appointment',
        '5-5' => 'procedure'
    ];

    /**
     * @var array
     */
    protected static $EMVITALS_EVAL_VALUES = [
        '6-1' => 'emVitals PHQ8 Score',
        '6-2' => 'emVitals GAD7 Score',
        '6-3' => 'emVitals PCLC6 Score',
        '6-4' => 'emVitals Audit C Score',
        '6-5' => 'emVitals SODU Score',
        '6-6' => 'emVitals PSS4 Score',
        '6-7' => 'emVitals OSLO3 Score',
        '6-8' => 'emVitals SDOH4',
        '6-9' => 'emVitals SDOH5',
        '6-10'=> 'emVitals SDOH6',
        '6-11'=> 'emVitals PHQ3',
        '6-12'=> 'emVitals SF21',
        '6-13'=> 'emVitals CC1'
    ];

    /**
     * @var array
     */
    protected static $EMVITALS_EVAL_FIELDS = [
        '6-1' => 'emv_phq8score',
        '6-2' => 'emv_gad7score',
        '6-3' => 'emv_pclc6score',
        '6-4' => 'emv_auditcscore',
        '6-5' => 'emv_spduscore',
        '6-6' => 'emv_pss4score',
        '6-7' => 'emv_oslo3score',
        '6-8' => 'emv_sdoh4',
        '6-9' => 'emv_sdoh5',
        '6-10'=> 'emv_sdoh6',
        '6-11'=> 'emv_phq3',
        '6-12'=> 'emv_sf21',
        '6-13'=> 'emv_cc1'
    ];

    /**
     * @var array
     */
    public static $evaluationTypes = [
        1 => 'Program Enrollment',
        2 => 'Value Comparison',
        3 => 'Value Range',
    ];

    /**
     * @var array
     */
    public static $copdStagesMap = [
        1 => 'Stage I',
        2 => 'Stage II',
        3 => 'Stage III',
        4 => 'Stage IV'
    ];

    /**
     * @var array
     */
    public static $phq9RangesMap = [
        1 => '<5: Negative',
        2 => '5-9: Minimal Symptoms',
        3 => '10-14: Minor Depression',
        4 => '15-19: Major Depression, moderately severe',
        5 => '>20: Major Depression, severe'
    ];

    /**
     * @var array
     */
    public $phq9RangesEvalMap = [
        1 => '<5',
        2 => '5-9',
        3 => '10-14',
        4 => '15-19',
        5 => '>20'
    ];

    /**
     * @var array
     */
    public static $employeeTypesMap = [
        1 => 'Employee',
        2 => 'Spouse',
        3 => 'Dependent',
        4 => 'Retiree',
        5 => 'Domestic Partner',
        6 => 'Other'
    ];

    /**
     * @var array
     */
    public static $raceMap = [
        'indian' => 'American Indian or Alaska Native',
        'asian' => 'Asian',
        'black' => 'Black or African American',
        'hawaiian' => 'Native Hawaiian or Other Pacific Islander',
        'white' => 'White or Caucasian',
        'blank' => 'Other Race',
        'declined' => 'Declined to Answer'
    ];

    /**
     * @var array
     */
    public static $criticalValueToSnapshotMap = [
        '1-1' => 'systolic',
        '1-2' => 'diastolic',
        '1-3' => 'bmi',
        '2-1' => 'glucose', // TODO we need to change this to fasting
        '2-2' => 'total_cholesterol',
        '2-3' => 'ldl',
        '2-4' => 'triglycerides',
        '2-5' => 'a1c',
        '2-6' => 'creatinine',
        '2-7' => 'bun',
        '2-8' => 'egfr',
        '2-9' => 'non_fasting_glucose',
        '5-1' => 'copd_stage',
        '5-2' => 'phq9_score'
    ];

    /**
     * @return array
     */
    public static function GetEvalValues()
    {
        return self::$VITALS_EVAL_VALUES
            + self::$LAB_EVAL_VALUES
            + self::$DEMOGRAPHIC_EVAL_VALUES
            + self::$OTHER_EVAL_VALUES
            + self::$EMVITALS_EVAL_VALUES;
    }

    /**
     * @return array
     */
    public static function GetProgramValues()
    {
        return self::$PROGRAM_EVAL_VALUES;
    }

    /**
     * @param $evalKey
     * @return mixed
     */
    public function getEvaluationValueName($evalKey)
    {
        $allValues = self::$VITALS_EVAL_VALUES
            + self::$LAB_EVAL_VALUES
            + self::$DEMOGRAPHIC_EVAL_VALUES
            + self::$PROGRAM_EVAL_VALUES
            + self::$OTHER_EVAL_VALUES
            + self::$EMVITALS_EVAL_VALUES;

        return $allValues[$evalKey];
    }

    /**
     * @param $evalKey
     * @param $historical
     * @return mixed
     */
    public function getEvaluationFieldName($evalKey, $historical)
    {
        $allValues = self::$VITALS_EVAL_FIELDS
            + self::$LAB_EVAL_FIELDS
            + self::$DEMOGRAPHIC_EVAL_FIELDS
            //+ self::$PROGRAM_EVAL_VALUES //TODO need to update this when CPT codes are implemented
            + self::$OTHER_EVAL_FIELDS
            + self::$EMVITALS_EVAL_FIELDS;

        return $historical ?
            (isset($allValues[$evalKey . '-historical']) ? $allValues[$evalKey . '-historical'] : $allValues[$evalKey])
            : $allValues[$evalKey];
    }

    /**
     * @param $evalKey
     * @param $comparatorValue
     * @return mixed
     */
    public function getComparatorValueName($evalKey, $comparatorValue)
    {
        $returnValue = $comparatorValue;

        if ($evalKey == '5-1')
        {
            if (isset(self::$copdStagesMap[$comparatorValue]))
            {
                $returnValue = self::$copdStagesMap[$comparatorValue];
            }
        }
        elseif ($evalKey == '5-2')
        {
            if (isset(self::$phq9RangesMap[$comparatorValue]))
            {
                $returnValue = self::$phq9RangesMap[$comparatorValue];
            }
        }
        elseif ($evalKey == '5-3')
        {
            $diagnosis = DiagnosisDefinitions::find($comparatorValue);
            if (isset($diagnosis))
            {
                $returnValue = $diagnosis->diagnosis_name;
            }
        }
        elseif ($evalKey == '5-4'){
            $appointmentProfile = AppointmentProfile::where('drchrono_appointment_profile_id',$comparatorValue)->first();
            if(isset($appointmentProfile)){
                $returnValue = $appointmentProfile->name;
            }
        }
        elseif ($evalKey == '5-5')
        {
            $procedure = ProcedureDefinitions::find($comparatorValue);
            if (isset($procedure))
            {
                $returnValue = $procedure->procedure_name;
            }
        }
        elseif ($evalKey == '3-3')
        {
            $client = Client::find($comparatorValue);
            if (isset($client))
            {
                $returnValue =$client->name;
            }
        }
        elseif ($evalKey == '3-4')
        {
            if (isset(self::$employeeTypesMap[$comparatorValue]))
            {
                $returnValue = self::$employeeTypesMap[$comparatorValue];
            }
        }
        elseif ($evalKey == '3-6')
        {
            if (isset(self::$raceMap[$comparatorValue]))
            {
                $returnValue = self::$raceMap[$comparatorValue];
            }
        }

        return $returnValue;
    }

    /**
     * @param $componentNode
     * @return array
     */
    public function getRuleSetComponents($componentNode){ // from component_ids to component_array
        $componentsOrder = [];

        if($componentNode['component'] == '&' || $componentNode['component'] == '|' || $componentNode['component'] == '!') {
            $parentNode = $componentNode['component'];
            $childNodes = [];
            foreach ($componentNode['children'] as $childNode) {
                array_push($childNodes, self::getRuleSetComponents($childNode));
            }
            $componentsOrder = [
                'component' => $parentNode,
                'children' => $childNodes
            ];
        }else{
            $componentsOrder = [
                'component' => RuleSetComponents::find($componentNode['component']),
                'children' => null
            ];
        }
        return $componentsOrder;
    }

    /**
     * @param $componentNode
     * @return string
     */
    public function getRuleSetDescriptions($componentNode){
        $description = '';

        if($componentNode['component'] == '&'){
            $description = $description.'( ';
            $conditions = [];
            foreach ($componentNode['children'] as $childNode) {
                array_push($conditions, self::getRuleSetDescriptions($childNode));
            }
            $description = $description.implode(' AND ', $conditions);
            $description = $description.' )';
        }
        elseif($componentNode['component'] == '|'){
            $description = $description.'( ';
            $conditions = [];
            foreach ($componentNode['children'] as $childNode) {
                array_push($conditions, self::getRuleSetDescriptions($childNode));
            }
            $description = $description.implode(' OR ', $conditions);
            $description = $description.' )';
        }elseif($componentNode['component'] == '!') {
            $description = $description.'( NOT ';
            $condition = [];
            foreach ($componentNode['children'] as $childNode) {
                array_push($condition, self::getRuleSetDescriptions($childNode));
            }
            $description = $description.$condition[0];
            $description = $description.' )';

        }else{
            $component = RuleSetComponents::find($componentNode['component']);
            $description = $component->description;
        }
        return $description;

    }

    /**
     * @param $value
     * @return string
     */
    protected function sanitizeClinicalValue($value)
    {
        return trim(preg_replace("/[^0-9.]/", "", $value));
    }

    /**
     * @param $birthdate
     * @return int
     * @throws \Exception
     */

    protected function ageFromBirthdate($birthdate)
    {
        return date_diff($birthdate, new \DateTime())->y;
    }
}