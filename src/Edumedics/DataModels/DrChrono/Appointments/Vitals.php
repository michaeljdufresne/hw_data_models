<?php

namespace Edumedics\DataModels\DrChrono\Appointments;

use Edumedics\DataModels\DrChrono\BaseModel;

class Vitals extends BaseModel
{

    /**
     * @var integer
     */
    protected $blood_pressure_1;

    /**
     * @var integer
     */
    protected $blood_pressure_2;

    /**
     * @var string
     */
    protected $head_circumference;

    /**
     * @var string
     */
    protected $head_circumference_units;

    /**
     * @var float
     */
    protected $height;

    /**
     * @var string
     */
    protected $height_units;

    /**
     * @var float
     */
    protected $oxygen_saturation;

    /**
     * @var string
     */
    protected $pain;

    /**
     * @var integer
     */
    protected $pulse;

    /**
     * @var integer
     */
    protected $respiratory_rate;

    /**
     * @var string
     */
    protected $smoking_status;

    /**
     * @var float
     */
    protected $temperature;

    /**
     * @var string
     */
    protected $temperature_units;

    /**
     * @var float
     */
    protected $weight;

    /**
     * @var string
     */
    protected $weight_units;

    /**
     * @var float
     */
    protected $bmi;

    /**
     * @var array
     */
    protected $rules = array(
        'blood_pressure_1' => 'integer',
        'blood_pressure_2' => 'integer',
        'height' => 'numeric',
        'oxygen_saturation' => 'numeric',
        'pulse' => 'integer',
        'respiratory_rate' => 'integer',
        'temperature' => 'numeric',
        'weight' => 'numeric',
        'bmi' => 'numeric'
    );

    /**
     * Vitals constructor.
     * @param int $blood_pressure_1
     * @param int $blood_pressure_2
     * @param string $head_circumference
     * @param string $head_circumference_units
     * @param float $height
     * @param string $height_units
     * @param float $oxygen_saturation
     * @param string $pain
     * @param int $pulse
     * @param int $respiratory_rate
     * @param string $smoking_status
     * @param float $temperature
     * @param string $temperature_units
     * @param float $weight
     * @param string $weight_units
     */
    public function __construct($blood_pressure_1 = null, $blood_pressure_2 = null, $head_circumference = null, $head_circumference_units = null,
                                $height = null, $height_units = null, $oxygen_saturation = null, $pain = null, $pulse = null,
                                $respiratory_rate = null, $smoking_status = null, $temperature = null, $temperature_units = null,
                                $weight = null, $weight_units = null)
    {
        $this->blood_pressure_1 = $blood_pressure_1;
        $this->blood_pressure_2 = $blood_pressure_2;
        $this->head_circumference = $head_circumference;
        $this->head_circumference_units = $head_circumference_units ?: "inches";
        $this->height = $height;
        $this->height_units = $height_units ?: "inches";
        $this->oxygen_saturation = $oxygen_saturation;
        $this->pain = $pain;
        $this->pulse = $pulse;
        $this->respiratory_rate = $respiratory_rate;
        $this->smoking_status = $smoking_status ?: "blank";
        $this->temperature = $temperature;
        $this->temperature_units = $temperature_units ?: "f";
        $this->weight = $weight;
        $this->weight_units = $weight_units ?: "lbs";
    }

    public function jsonSerialize()
    {
        return [
            'blood_pressure_1' => $this->blood_pressure_1,
            'blood_pressure_2' => $this->blood_pressure_2,
            'head_circumference' => $this->head_circumference,
            'head_circumference_units' => $this->head_circumference_units,
            'height' => $this->height,
            'height_units' => $this->height_units,
            'oxygen_saturation' => $this->oxygen_saturation,
            'pain' => $this->pain,
            'pulse' => $this->pulse,
            'respiratory_rate' => $this->respiratory_rate,
            'smoking_status' => $this->smoking_status,
            'temperature' => $this->temperature,
            'temperature_units' => $this->temperature_units,
            'weight' => $this->weight,
            'weight_units' => $this->weight_units,
            'bmi' => $this->bmi
        ];
    }

}