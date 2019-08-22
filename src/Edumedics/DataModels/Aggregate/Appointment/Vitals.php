<?php

namespace Edumedics\DataModels\Aggregate\Appointment;

use Edumedics\DataModels\Dto\Common\Appointment\VitalsDto;
use Edumedics\DataModels\Dto\Common\Enums\UnitsOfMeasure;
use Edumedics\DataModels\Dto\Common\Enums\VitalType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Vitals extends Model
{

    /**
     * @var string
     */
    protected $table = 'drchrono_appointment_vitals';

    /**
     * @var string
     */
    protected $connection = 'pgsql_tenant';

    /**
     * @param $v
     * @return mixed|null
     */
    protected function getCustomVitalName($v)
    {
        $prodMap = [
            2298    => "cuff_size",
            2300    => "bp_position",
            2302    => "bp_arm",
            2306    => "30_min_prior_to_bp",
            2308    => "wrist_pulse_status",
            2310    => "ankle_pulse_status",
            2312    => "goal_weight",
            2314    => "goal_weight_recommendations",
            2316    => "waist_circumference",
            2318    => "bp_monitoring_notes",
            2382    => "secondary_bp"
        ];

        $qaMap = [
            4304    => "cuff_size",
            4306    => "bp_position",
            4308    => "bp_arm",
            4310    => "30_min_prior_to_bp",
            4312    => "wrist_pulse_status",
            4314    => "ankle_pulse_status",
            4316    => "goal_weight",
            4318    => "goal_weight_recommendations",
            4320    => "waist_circumference",
            4322    => "bp_monitoring_notes",
            4324    => "secondary_bp"
        ];

        if (env('APP_ENV') == 'prod')
        {
            if (isset($prodMap[$v]))
            {
                return $prodMap[$v];
            }
        }
        if (isset($qaMap[$v]))
        {
            return $qaMap[$v];
        }
        return null;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function appointment()
    {
        return $this->belongsTo('Edumedics\DataModels\Aggregate\Appointment', 'drchrono_appointment_id', 'drchrono_appointment_id');
    }

    /**
     * TODO remove
     * @param \Edumedics\DataModels\DrChrono\Appointments\Vitals $vitals
     * @param $customVitals
     */
    public function populate(\Edumedics\DataModels\DrChrono\Appointments\Vitals $vitals, $customVitals)
    {
        foreach ($vitals->jsonSerialize() as $k => $v)
        {
            $this->{$k} = $v;
        }
        if (empty($customVitals)) return;

        foreach ($customVitals as $customVital)
        {
            $vitalName = $this->getCustomVitalName($customVital->vital_type);
            if (isset($vitalName))
            {
                $this->{$vitalName} = $customVital->value;
            }
        }
    }

    public function populateFromDto($vitals, $appointmentId) // array of VitalDto, emrApptID
    {
        if (isset($vitals) && is_array($vitals)) {
            $this->drchrono_appointment_id = $appointmentId;
            $secondaryBp1 = null;
            $secondaryBp2 = null;
            Log::info('Populating Vitals from Dto');
            foreach ($vitals as $vitalDto) {
                switch ($vitalDto['vital_type']) {
                    case VitalType::BloodPressure1:
                        $this->blood_pressure_1 = $vitalDto['value'];
                        break;
                    case VitalType::BloodPressure2:
                        $this->blood_pressure_2 = $vitalDto['value'];
                        break;
                    case VitalType::HeadCircumference:
                        $this->head_circumference = $vitalDto['value'];
                        $this->head_circumference_units = UnitsOfMeasure::getUnitText($vitalDto['unit_of_measure']);
                        break;
                    case VitalType::Height:
                        $this->height = $vitalDto['value'];
                        $this->height_units = UnitsOfMeasure::getUnitText($vitalDto['unit_of_measure']);
                        break;
                    case VitalType::OxygenSaturation:
                        $this->oxygen_saturation = $vitalDto['value'];
                        break;
                    case VitalType::Pain:
                        $this->pain = $vitalDto['value'];
                        break;
                    case VitalType::Pulse:
                        $this->pulse = $vitalDto['value'];
                        break;
                    case VitalType::RespiratoryRate:
                        $this->respiratory_rate = $vitalDto['value'];
                        break;
                    case VitalType::SmokingStatus:
                        $this->smoking_status = $vitalDto['value'];
                        break;
                    case VitalType::Temperature:
                        $this->temperature = $vitalDto['value'];
                        $this->temperature_units = UnitsOfMeasure::getUnitText($vitalDto['unit_of_measure']);
                        break;
                    case VitalType::Weight:
                        $this->weight = $vitalDto['value'];
                        $this->weight_units = UnitsOfMeasure::getUnitText($vitalDto['unit_of_measure']);
                        break;
                    case VitalType::BMI:
                        $this->bmi = $vitalDto['value'];
                        break;
                    case VitalType::CuffSize:
                        $this->cuff_size = $vitalDto['value'];
                        break;
                    case VitalType::BpPosition:
                        $this->bp_position = $vitalDto['value'];
                        break;
                    case VitalType::BpArm:
                        $this->bp_arm = $vitalDto['value'];
                        break;
                    case VitalType::ThirtyMinutesPriorToBp:
                        $column_name = '30_min_prior_to_bp';
                        $this->{$column_name} = $vitalDto['value'];
                        break;
                    case VitalType::WristPulseStatus:
                        $this->wrist_pulse_status = $vitalDto['value'];
                        break;
                    case VitalType::AnklePulseStatus:
                        $this->ankle_pilse_status = $vitalDto['value'];
                        break;
                    case VitalType::GoalWeight:
                        $this->goal_weight = $vitalDto['value'];
                        break;
                    case VitalType::GoalWeightRecommendations:
                        $this->goal_weight_recommendations = $vitalDto['value'];
                        break;
                    case VitalType::WaistCircumference:
                        $this->waist_circumference = $vitalDto['value'];
                        break;
                    case VitalType::BpMonitoringNotes:
                        $this->bp_monitoring_notes = $vitalDto['value'];
                        break;
                    case VitalType::SecondaryBp1:
                        $secondaryBp1 = $vitalDto['value'];
                        if(isset($secondaryBp2) && isset($secondaryBp1)){
                            $this->secondary_bp = $secondaryBp1.'/'.$secondaryBp2;
                        }
                        break;
                    case VitalType::SecondaryBp2:
                        $secondaryBp2 = $vitalDto['value'];
                        if(isset($secondaryBp1) && isset($secondaryBp2)){
                            $this->secondary_bp = $secondaryBp1.'/'.$secondaryBp2;
                        }
                        break;
                    default:
                        break;
                }
            }
        }
    }


}