<?php


namespace Edumedics\DataModels\Dto\Common;


use Edumedics\DataModels\Aggregate\Appointment\Vitals;
use Edumedics\DataModels\Dto\Common\Appointment\BillingNoteDto;
use Edumedics\DataModels\Dto\Common\Appointment\ClinicalNoteDto;
use Edumedics\DataModels\Dto\Common\Appointment\VitalsDto;
use Edumedics\DataModels\Dto\Common\Enums\UnitsOfMeasure;
use Edumedics\DataModels\Dto\Common\Enums\VitalType;
use Edumedics\DataModels\Dto\Dto;
use Illuminate\Support\Facades\Log;

/**
 * Class AppointmentDto
 * @package Edumedics\DataModels\Dto\Common
 * @OA\Schema( schema="AppointmentDto" )
 */
class AppointmentDto extends Dto
{
    /**
     * @var integer
     * @OA\Property(format="int64")
     */
    public $appointment_id;

    /**
     * @var ExternalIdDto[]
     * @OA\Property()
     */
    public $external_ids;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $doctor_id;

    /**
     * @var integer
     * @OA\Property(format="string")
     */
    public $duration;

    /**
     * @var integer
     * @OA\Property(format="int64")
     */
    public $exam_room;

    /**
     * @var integer
     * @OA\Property(format="int64")
     */
    public $office_id;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $patient_id;

    /**
     * @var \DateTime
     * @OA\Property()
     * "Y-m-d\TH:i:s"
     */
    public $scheduled_time;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $color;

    /**
     * @var VitalsDto[]
     * @OA\Property()
     */
    public $vitals;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $notes;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $profile_id;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $reason;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $status;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $billing_status;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $billing_provider;

    /**
     * @var BillingNoteDto[]
     * @OA\Property()
     */
    public $billing_notes;

    /**
     * @var ClinicalNoteDto
     * @OA\Property()
     */
    public $clinical_note;

    /**
     * @var string[]
     * @OA\Property()
     */
    public $icd10_codes;

    /**
     * @var string[]
     * @OA\Property()
     */
    public $icd9_codes;

    /**
     * @var \DateTime
     * @OA\Property()
     * "Y-m-d\TH:i:s"
     */
    public $first_billed_date;

    /**
     * @var \DateTime
     * @OA\Property()
     * "Y-m-d\TH:i:s"
     */
    public $last_billed_date;

    /**
     * @var boolean
     * @OA\Property()
     */
    public $allow_overlapping;

    /**
     * @var boolean
     * @OA\Property()
     */
    public $recurring_appointment;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $base_recurring_appointment;

    /**
     * @var boolean
     * @OA\Property()
     */
    public $is_walk_in;

    /**
     * @var \DateTime
     * @OA\Property()
     * "Y-m-d\TH:i:s"
     */
    public $created_at;

    /**
     * @var \DateTime
     * @OA\Property()
     * "Y-m-d\TH:i:s"
     */
    public $updated_at;

    /**
     * @var \DateTime
     * @OA\Property()
     * "Y-m-d\TH:i:s"
     */
    public $extended_updated_at;

    /**
     * @var array
     */
    protected $fillable = ['appointment_id','external_ids','doctor_id','duration','exam_room','office_id','patient_id','scheduled_time','color','vitals','notes','profile_id',
        'reason','status','billing_status','billing_provider','billing_notes','clinical_note','icd10_codes','icd9_codes',
        'first_billed_date','last_billed_date','allow_overlapping','recurring_appointment','base_recurring_appointment','is_walk_in','created_at','updated_at',
        'extended_updated_at'];

    /**
     * @param null $dataArray
     * @return mixed|void
     * @throws \Exception
     */
    public function populate($dataArray = null)
    {
        if (isset($dataArray) && is_array($dataArray)) {
            foreach ($dataArray as $k => $v) {
                switch ($k){
                    case '_id':
                        $this->appointment_id = $v;
                        break;
                    case 'external_ids':
                        $this->{$k} = [];
                        foreach ($v as $externalId) {
                            $externalIdDto = new ExternalIdDto();
                            $externalIdDto->populate($externalId);
                            $this->{$k}[] = $externalIdDto;
                        }
                        break;
                    case 'drchrono_appointment_id':
                        if (!empty($v))
                        {
                            $externalIdDto = new ExternalIdDto();
                            $externalIdDto->fill([
                                'id' => $v,
                                'type' => ExternalIdDto::DrChronoId
                            ]);
                            $this->external_ids[] = $externalIdDto;
                        }
                        break;
                    case 'doctor':
                        $this->doctor_id = $v;
                        break;
                    case 'office':
                        $this->office_id = $v;
                        break;
                    case 'patient':
                        $this->patient_id = $v;
                        break;
                    case 'profile':
                        $this->profile_id = $v;
                        break;
                    case 'billing_notes':
                        $this->{$k} = [];
                        foreach ($v as $billingNote) {
                            $billingNoteDto = new BillingNoteDto();
                            $billingNoteDto->populate($billingNote);
                            $this->{$k}[] = $billingNoteDto;
                        }
                        break;
                    case 'vitals':
                        $this->{$k} = [];
                        //$handleVitals = false;
                        foreach ($v as $key => $value){
                            Log::info($key);
                            Log::info($value);
                            if(is_numeric($key)){
                                Log::info("I'm in default.");
                                $vitalDto = new VitalsDto();
                                $vitalDto->populate($value);
                                $this->{$k}[] = $vitalDto;
                            }else if(is_string($key)){
                                //$handleVitals = true;
                                switch ($key) {
                                    case 'blood_pressure_1':
                                        Log::info('Im in BP1');
                                        $vital = [
                                            'vital_type' => VitalType::BloodPressure1,
                                            'value' => $value,
                                            'unit_of_measure' => UnitsOfMeasure::__default
                                        ];
                                        $vitalDto = new VitalsDto();
                                        $vitalDto->populate($vital);
                                        $this->{$k}[] = $vitalDto;
                                        break;
                                    case 'blood_pressure_2':
                                        $vital = [
                                            'vital_type' => VitalType::BloodPressure2,
                                            'value' => $value,
                                            'unit_of_measure' => UnitsOfMeasure::__default
                                        ];
                                        $vitalDto = new VitalsDto();
                                        $vitalDto->populate($vital);
                                        $this->{$k}[] = $vitalDto;
                                        break;
                                    case 'head_circumference':
                                        $vital = [
                                            'vital_type' => VitalType::HeadCircumference,
                                            'value' => $value,
                                            'unit_of_measure' => UnitsOfMeasure::getUnitEnum($v['head_circumference_units'])
                                        ];
                                        $vitalDto = new VitalsDto();
                                        $vitalDto->populate($vital);
                                        $this->{$k}[] = $vitalDto;
                                        break;
                                    case 'height':
                                        $vital = [
                                            'vital_type' => VitalType::Height,
                                            'value' => $value,
                                            'unit_of_measure' => UnitsOfMeasure::getUnitEnum($v['height_units'])
                                        ];
                                        $vitalDto = new VitalsDto();
                                        $vitalDto->populate($vital);
                                        $this->{$k}[] = $vitalDto;
                                        break;
                                    case 'oxygen_saturation':
                                        $vital = [
                                            'vital_type' => VitalType::OxygenSaturation,
                                            'value' => $value,
                                            'unit_of_measure' => UnitsOfMeasure::__default
                                        ];
                                        $vitalDto = new VitalsDto();
                                        $vitalDto->populate($vital);
                                        $this->{$k}[] = $vitalDto;
                                        break;
                                    case 'pain':
                                        $vital = [
                                            'vital_type' => VitalType::Pain,
                                            'value' => $value,
                                            'unit_of_measure' => UnitsOfMeasure::__default
                                        ];
                                        $vitalDto = new VitalsDto();
                                        $vitalDto->populate($vital);
                                        $this->{$k}[] = $vitalDto;
                                        break;
                                    case 'pulse':
                                        $vital = [
                                            'vital_type' => VitalType::Pulse,
                                            'value' => $value,
                                            'unit_of_measure' => UnitsOfMeasure::__default
                                        ];
                                        $vitalDto = new VitalsDto();
                                        $vitalDto->populate($vital);
                                        $this->{$k}[] = $vitalDto;
                                        break;
                                    case 'respiratory_rate':
                                        $vital = [
                                            'vital_type' => VitalType::RespiratoryRate,
                                            'value' => $value,
                                            'unit_of_measure' => UnitsOfMeasure::__default
                                        ];
                                        $vitalDto = new VitalsDto();
                                        $vitalDto->populate($vital);
                                        $this->{$k}[] = $vitalDto;
                                        break;
                                    case 'smoking_status':
                                        $vital = [
                                            'vital_type' => VitalType::SmokingStatus,
                                            'value' => $value,
                                            'unit_of_measure' => UnitsOfMeasure::__default
                                        ];
                                        $vitalDto = new VitalsDto();
                                        $vitalDto->populate($vital);
                                        $this->{$k}[] = $vitalDto;
                                        break;
                                    case 'temperature':
                                        $vital = [
                                            'vital_type' => VitalType::Temperature,
                                            'value' => $value,
                                            'unit_of_measure' => UnitsOfMeasure::getUnitEnum($v['temperature_units'])
                                        ];
                                        $vitalDto = new VitalsDto();
                                        $vitalDto->populate($vital);
                                        $this->{$k}[] = $vitalDto;
                                        break;
                                    case 'weight':
                                        $vital = [
                                            'vital_type' => VitalType::Weight,
                                            'value' => $value,
                                            'unit_of_measure' => UnitsOfMeasure::getUnitEnum($v['weight_units'])
                                        ];
                                        $vitalDto = new VitalsDto();
                                        $vitalDto->populate($vital);
                                        $this->{$k}[] = $vitalDto;
                                        break;
                                    case 'bmi':
                                        $vital = [
                                            'vital_type' => VitalType::BMI,
                                            'value' => $value,
                                            'unit_of_measure' => UnitsOfMeasure::__default
                                        ];
                                        $vitalDto = new VitalsDto();
                                        $vitalDto->populate($vital);
                                        $this->{$k}[] = $vitalDto;
                                        break;
                                    case 'cuff_size':
                                        $vital = [
                                            'vital_type' => VitalType::CuffSize,
                                            'value' => $value,
                                            'unit_of_measure' => UnitsOfMeasure::__default
                                        ];
                                        $vitalDto = new VitalsDto();
                                        $vitalDto->populate($vital);
                                        $this->{$k}[] = $vitalDto;
                                        break;
                                    case 'bp_position':
                                        $vital = [
                                            'vital_type' => VitalType::BpPosition,
                                            'value' => $value,
                                            'unit_of_measure' => UnitsOfMeasure::__default
                                        ];
                                        $vitalDto = new VitalsDto();
                                        $vitalDto->populate($vital);
                                        $this->{$k}[] = $vitalDto;
                                        break;
                                    case 'bp_arm':
                                        $vital = [
                                            'vital_type' => VitalType::BpArm,
                                            'value' => $value,
                                            'unit_of_measure' => UnitsOfMeasure::__default
                                        ];
                                        $vitalDto = new VitalsDto();
                                        $vitalDto->populate($vital);
                                        $this->{$k}[] = $vitalDto;
                                        break;
                                    case '30_min_prior_to_bp':
                                        $vital = [
                                            'vital_type' => VitalType::ThirtyMinutesPriorToBp,
                                            'value' => $value,
                                            'unit_of_measure' => UnitsOfMeasure::__default
                                        ];
                                        $vitalDto = new VitalsDto();
                                        $vitalDto->populate($vital);
                                        $this->{$k}[] = $vitalDto;
                                        break;
                                    case 'wrist_pulse_status':
                                        $vital = [
                                            'vital_type' => VitalType::WristPulseStatus,
                                            'value' => $value,
                                            'unit_of_measure' => UnitsOfMeasure::__default
                                        ];
                                        $vitalDto = new VitalsDto();
                                        $vitalDto->populate($vital);
                                        $this->{$k}[] = $vitalDto;
                                        break;
                                    case 'ankle_pulse_status':
                                        $vital = [
                                            'vital_type' => VitalType::AnklePulseStatus,
                                            'value' => $value,
                                            'unit_of_measure' => UnitsOfMeasure::__default
                                        ];
                                        $vitalDto = new VitalsDto();
                                        $vitalDto->populate($vital);
                                        $this->{$k}[] = $vitalDto;
                                        break;
                                    case 'goal_weight':
                                        $vital = [
                                            'vital_type' => VitalType::GoalWeight,
                                            'value' => $value,
                                            'unit_of_measure' => UnitsOfMeasure::__default
                                        ];
                                        $vitalDto = new VitalsDto();
                                        $vitalDto->populate($vital);
                                        $this->{$k}[] = $vitalDto;
                                        break;
                                    case 'goal_weight_recommendations':
                                        $vital = [
                                            'vital_type' => VitalType::GoalWeightRecommendations,
                                            'value' => $value,
                                            'unit_of_measure' => UnitsOfMeasure::__default
                                        ];
                                        $vitalDto = new VitalsDto();
                                        $vitalDto->populate($vital);
                                        $this->{$k}[] = $vitalDto;
                                        break;
                                    case 'waist_circumference':
                                        $vital = [
                                            'vital_type' => VitalType::WaistCircumference,
                                            'value' => $value,
                                            'unit_of_measure' => UnitsOfMeasure::__default
                                        ];
                                        $vitalDto = new VitalsDto();
                                        $vitalDto->populate($vital);
                                        $this->{$k}[] = $vitalDto;
                                        break;
                                    case 'bp_monitoring_notes':
                                        $vital = [
                                            'vital_type' => VitalType::BpMonitoringNotes,
                                            'value' => $value,
                                            'unit_of_measure' => UnitsOfMeasure::__default
                                        ];
                                        $vitalDto = new VitalsDto();
                                        $vitalDto->populate($vital);
                                        $this->{$k}[] = $vitalDto;
                                        break;
                                    case 'secondary_bp':
                                        $secondaryBp = explode('/', $value);
                                        // Systolic
                                        $vital = [
                                            'vital_type' => VitalType::SecondaryBp1,
                                            'value' => $secondaryBp[0],
                                            'unit_of_measure' => UnitsOfMeasure::__default
                                        ];
                                        $vitalDto = new VitalsDto();
                                        $vitalDto->populate($vital);
                                        $this->{$k}[] = $vitalDto;
                                        // Diastolic
                                        $vital = [
                                            'vital_type' => VitalType::SecondaryBp2,
                                            'value' => $secondaryBp[1],
                                            'unit_of_measure' => UnitsOfMeasure::__default
                                        ];
                                        $vitalDto = new VitalsDto();
                                        $vitalDto->populate($vital);
                                        $this->{$k}[] = $vitalDto;
                                        break;
                                }
                            }
                        }
                        break;
                    case 'clinical_note':
                        $clinicalNote = new ClinicalNoteDto();
                        $clinicalNote->populate($v);
                        $this->{$k} = $clinicalNote;
                        break;
                    case 'first_billed_date':
                    case 'last_billed_date':
                    case 'scheduled_time':
                    case 'extended_updated_at':
                    case 'updated_at':
                    case 'created_at':
                        $this->{$k} = new \DateTime($v);
                        break;
                    default:
                        $this->{$k} = $v;
                        break;
                }
            }
        }
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'appointment_id' => $this->appointment_id,
            'external_ids' => $this->jsonSerializeArray($this->external_ids),
            'doctor_id' => $this->doctor_id,
            'duration' => $this->duration,
            'exam_room' => $this->exam_room,
            'office_id' => $this->office_id,
            'patient_id' => $this->patient_id,
            'scheduled_time' => $this->formatDateTime($this->scheduled_time),
            'color' => $this->color,
            'vitals' => $this->jsonSerializeArray($this->vitals),
            'notes' => $this->notes,
            'profile_id' => $this->profile_id,
            'reason' => $this->reason,
            'status' => $this->status,
            'billing_status' => $this->billing_status,
            'billing_provider' => $this->billing_provider,
            'billing_notes' => $this->jsonSerializeArray($this->billing_notes),
            'clinical_note' => $this->jsonSerializeObject($this->clinical_note),
            'icd10_codes' => $this->icd10_codes,
            'icd9_codes' => $this->icd9_codes,
            'first_billed_date' => $this->formatDateTime($this->first_billed_date),
            'last_billed_date' => $this->formatDateTime($this->last_billed_date),
            'allow_overlapping' => $this->allow_overlapping,
            'recurring_appointment' => $this->recurring_appointment,
            'base_recurring_appointment' => $this->base_recurring_appointment,
            'is_walk_in' => $this->is_walk_in,
            'created_at' => $this->formatDateTime($this->created_at),
            'updated_at' => $this->formatDateTime($this->updated_at),
            'extended_updated_at' => $this->formatDateTime($this->extended_updated_at)
        ];
    }

    private function vitalsHandling($vitals){
        $result = [];
        foreach ($vitals as $column_name => $value) {
            Log::info($column_name);
            Log::info($value);
            switch ($column_name) {
                case 'blood_pressure_1':
                    Log::info('Im in BP1');
                    $vital = [
                        'vital_type' => VitalType::BloodPressure1,
                        'value' => $value,
                        'unit_of_measure' => UnitsOfMeasure::__default
                    ];
                    $vitalDto = new VitalsDto();
                    $vitalDto->populate($vital);
                    $result[] = $vitalDto;
                    break;
                case 'blood_pressure_2':
                    $vital = [
                        'vital_type' => VitalType::BloodPressure2,
                        'value' => $value,
                        'unit_of_measure' => UnitsOfMeasure::__default
                    ];
                    $vitalDto = new VitalsDto();
                    $vitalDto->populate($vital);
                    $result[] = $vitalDto;
                    break;
                case 'head_circumference':
                    $vital = [
                        'vital_type' => VitalType::HeadCircumference,
                        'value' => $value,
                        'unit_of_measure' => UnitsOfMeasure::getUnitEnum($vitals['head_circumference_units'])
                    ];
                    $vitalDto = new VitalsDto();
                    $vitalDto->populate($vital);
                    $result[] = $vitalDto;
                    break;
                case 'height':
                    $vital = [
                        'vital_type' => VitalType::Height,
                        'value' => $value,
                        'unit_of_measure' => UnitsOfMeasure::getUnitEnum($vitals['height_units'])
                    ];
                    $vitalDto = new VitalsDto();
                    $vitalDto->populate($vital);
                    $result[] = $vitalDto;
                    break;
                case 'oxygen_saturation':
                    $vital = [
                        'vital_type' => VitalType::OxygenSaturation,
                        'value' => $value,
                        'unit_of_measure' => UnitsOfMeasure::__default
                    ];
                    $vitalDto = new VitalsDto();
                    $vitalDto->populate($vital);
                    $result[] = $vitalDto;
                    break;
                case 'pain':
                    $vital = [
                        'vital_type' => VitalType::Pain,
                        'value' => $value,
                        'unit_of_measure' => UnitsOfMeasure::__default
                    ];
                    $vitalDto = new VitalsDto();
                    $vitalDto->populate($vital);
                    $result[] = $vitalDto;
                    break;
                case 'pulse':
                    $vital = [
                        'vital_type' => VitalType::Pulse,
                        'value' => $value,
                        'unit_of_measure' => UnitsOfMeasure::__default
                    ];
                    $vitalDto = new VitalsDto();
                    $vitalDto->populate($vital);
                    $result[] = $vitalDto;
                    break;
                case 'respiratory_rate':
                    $vital = [
                        'vital_type' => VitalType::RespiratoryRate,
                        'value' => $value,
                        'unit_of_measure' => UnitsOfMeasure::__default
                    ];
                    $vitalDto = new VitalsDto();
                    $vitalDto->populate($vital);
                    $result[] = $vitalDto;
                    break;
                case 'smoking_status':
                    $vital = [
                        'vital_type' => VitalType::SmokingStatus,
                        'value' => $value,
                        'unit_of_measure' => UnitsOfMeasure::__default
                    ];
                    $vitalDto = new VitalsDto();
                    $vitalDto->populate($vital);
                    $result[] = $vitalDto;
                    break;
                case 'temperature':
                    $vital = [
                        'vital_type' => VitalType::Temperature,
                        'value' => $value,
                        'unit_of_measure' => UnitsOfMeasure::getUnitEnum($vitals['temperature_units'])
                    ];
                    $vitalDto = new VitalsDto();
                    $vitalDto->populate($vital);
                    $result[] = $vitalDto;
                    break;
                case 'weight':
                    $vital = [
                        'vital_type' => VitalType::Weight,
                        'value' => $value,
                        'unit_of_measure' => UnitsOfMeasure::getUnitEnum($vitals['weight_units'])
                    ];
                    $vitalDto = new VitalsDto();
                    $vitalDto->populate($vital);
                    $result[] = $vitalDto;
                    break;
                case 'bmi':
                    $vital = [
                        'vital_type' => VitalType::BMI,
                        'value' => $value,
                        'unit_of_measure' => UnitsOfMeasure::__default
                    ];
                    $vitalDto = new VitalsDto();
                    $vitalDto->populate($vital);
                    $result[] = $vitalDto;
                    break;
                case 'cuff_size':
                    $vital = [
                        'vital_type' => VitalType::CuffSize,
                        'value' => $value,
                        'unit_of_measure' => UnitsOfMeasure::__default
                    ];
                    $vitalDto = new VitalsDto();
                    $vitalDto->populate($vital);
                    $result[] = $vitalDto;
                    break;
                case 'bp_position':
                    $vital = [
                        'vital_type' => VitalType::BpPosition,
                        'value' => $value,
                        'unit_of_measure' => UnitsOfMeasure::__default
                    ];
                    $vitalDto = new VitalsDto();
                    $vitalDto->populate($vital);
                    $result[] = $vitalDto;
                    break;
                case 'bp_arm':
                    $vital = [
                        'vital_type' => VitalType::BpArm,
                        'value' => $value,
                        'unit_of_measure' => UnitsOfMeasure::__default
                    ];
                    $vitalDto = new VitalsDto();
                    $vitalDto->populate($vital);
                    $result[] = $vitalDto;
                    break;
                case '30_min_prior_to_bp':
                    $vital = [
                        'vital_type' => VitalType::ThirtyMinutesPriorToBp,
                        'value' => $value,
                        'unit_of_measure' => UnitsOfMeasure::__default
                    ];
                    $vitalDto = new VitalsDto();
                    $vitalDto->populate($vital);
                    $result[] = $vitalDto;
                    break;
                case 'wrist_pulse_status':
                    $vital = [
                        'vital_type' => VitalType::WristPulseStatus,
                        'value' => $value,
                        'unit_of_measure' => UnitsOfMeasure::__default
                    ];
                    $vitalDto = new VitalsDto();
                    $vitalDto->populate($vital);
                    $result[] = $vitalDto;
                    break;
                case 'ankle_pulse_status':
                    $vital = [
                        'vital_type' => VitalType::AnklePulseStatus,
                        'value' => $value,
                        'unit_of_measure' => UnitsOfMeasure::__default
                    ];
                    $vitalDto = new VitalsDto();
                    $vitalDto->populate($vital);
                    $result[] = $vitalDto;
                    break;
                case 'goal_weight':
                    $vital = [
                        'vital_type' => VitalType::GoalWeight,
                        'value' => $value,
                        'unit_of_measure' => UnitsOfMeasure::__default
                    ];
                    $vitalDto = new VitalsDto();
                    $vitalDto->populate($vital);
                    $result[] = $vitalDto;
                    break;
                case 'goal_weight_recommendations':
                    $vital = [
                        'vital_type' => VitalType::GoalWeightRecommendations,
                        'value' => $value,
                        'unit_of_measure' => UnitsOfMeasure::__default
                    ];
                    $vitalDto = new VitalsDto();
                    $vitalDto->populate($vital);
                    $result[] = $vitalDto;
                    break;
                case 'waist_circumference':
                    $vital = [
                        'vital_type' => VitalType::WaistCircumference,
                        'value' => $value,
                        'unit_of_measure' => UnitsOfMeasure::__default
                    ];
                    $vitalDto = new VitalsDto();
                    $vitalDto->populate($vital);
                    $result[] = $vitalDto;
                    break;
                case 'bp_monitoring_notes':
                    $vital = [
                        'vital_type' => VitalType::BpMonitoringNotes,
                        'value' => $value,
                        'unit_of_measure' => UnitsOfMeasure::__default
                    ];
                    $vitalDto = new VitalsDto();
                    $vitalDto->populate($vital);
                    $result[] = $vitalDto;
                    break;
                case 'secondary_bp':
                    $secondaryBp = explode('/', $value);
                    // Systolic
                    $vital = [
                        'vital_type' => VitalType::SecondaryBp1,
                        'value' => $secondaryBp[0],
                        'unit_of_measure' => UnitsOfMeasure::__default
                    ];
                    $vitalDto = new VitalsDto();
                    $vitalDto->populate($vital);
                    $result[] = $vitalDto;
                    // Diastolic
                    $vital = [
                        'vital_type' => VitalType::SecondaryBp2,
                        'value' => $secondaryBp[1],
                        'unit_of_measure' => UnitsOfMeasure::__default
                    ];
                    $vitalDto = new VitalsDto();
                    $vitalDto->populate($vital);
                    $result[] = $vitalDto;
                    break;
            }
        }
        return $result;
    }
}