<?php

namespace Edumedics\DataModels\DrChrono;

class ManualLabResults extends BaseModel
{

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var \DateTime
     */
    protected $created_at;

    /**
     * @var \DateTime
     */
    protected $date_test_performed;

    /**
     * @var boolean
     */
    protected $doctor_signoff;

    /**
     * @var string
     */
    protected $lab_abnormal_flag;

    /**
     * @var string
     */
    protected $lab_order_status;

    /**
     * @var string
     */
    protected $lab_result_value;

    /**
     * @var float
     */
    protected $lab_result_value_as_float;

    /**
     * @var string
     */
    protected $lab_result_value_units;

    /**
     * @var string
     */
    protected $loinc_code;

    /**
     * @var integer
     */
    protected $ordering_doctor;

    /**
     * @var integer
     */
    protected $patient;

    /**
     * @var integer
     */
    protected $scanned_in_result;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var \DateTime
     */
    protected $updated_at;

    /**
     * @var array
     */
    protected $rules = array();

    /**
     * ManualLabResults constructor.
     * @param int $id
     * @param \DateTime $created_at
     * @param \DateTime $date_test_performed
     * @param bool $doctor_signoff
     * @param string $lab_abnormal_flag
     * @param string $lab_order_status
     * @param string $lab_result_value
     * @param float $lab_result_value_as_float
     * @param string $lab_result_value_units
     * @param string $loinc_code
     * @param int $ordering_doctor
     * @param int $patient
     * @param int $scanned_in_result
     * @param string $title
     * @param \DateTime $updated_at
     */
    public function __construct($id = null, \DateTime $created_at = null, \DateTime $date_test_performed = null, $doctor_signoff = null,
                                $lab_abnormal_flag = null, $lab_order_status = null, $lab_result_value = null, $lab_result_value_as_float = null,
                                $lab_result_value_units = null, $loinc_code = null, $ordering_doctor = null, $patient = null,
                                $scanned_in_result = null, $title = null, \DateTime $updated_at = null)
    {
        $this->id = $id;
        $this->created_at = $created_at;
        $this->date_test_performed = $date_test_performed;
        $this->doctor_signoff = $doctor_signoff;
        $this->lab_abnormal_flag = $lab_abnormal_flag;
        $this->lab_order_status = $lab_order_status;
        $this->lab_result_value = $lab_result_value;
        $this->lab_result_value_as_float = $lab_result_value_as_float;
        $this->lab_result_value_units = $lab_result_value_units;
        $this->loinc_code = $loinc_code;
        $this->ordering_doctor = $ordering_doctor;
        $this->patient = $patient;
        $this->scanned_in_result = $scanned_in_result;
        $this->title = $title;
        $this->updated_at = $updated_at;
    }


    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'created_at' => $this->formatDateTime($this->created_at),
            'date_test_performed' => $this->formatDateTime($this->date_test_performed),
            'doctor_signoff' => $this->doctor_signoff,
            'lab_abnormal_flag' => $this->lab_abnormal_flag,
            'lab_order_status' => $this->lab_order_status,
            'lab_result_value' => $this->lab_result_value,
            'lab_result_value_as_float' => $this->lab_result_value_as_float,
            'lab_result_value_units' => $this->lab_result_value_units,
            'loinc_code' => $this->loinc_code,
            'ordering_doctor' => $this->ordering_doctor,
            'patient' => $this->patient,
            'scanned_in_result' => $this->scanned_in_result,
            'title' => $this->title,
            'updated_at' => $this->formatDateTime($this->updated_at)
        ];
    }

}