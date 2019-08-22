<?php

namespace Edumedics\DataModels\DrChrono;


class LabResults extends BaseModel
{

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var integer
     */
    protected $lab_order;

    /**
     * @var integer
     */
    protected $lab_test;

    /**
     * @var integer
     */
    protected $document;

    /**
     * @var \DateTime
     */
    protected $specimen_received;

    /**
     * @var \DateTime
     */
    protected $results_released;

    /**
     * @var \DateTime
     */
    protected $test_performed;

    /**
     * @var string
     */
    protected $status;

    /**
     * @var string
     */
    protected $value;

    /**
     * @var string
     */
    protected $abnormal_status;

    /**
     * @var boolean
     */
    protected $is_abnormal;

    /**
     * @var string
     */
    protected $normal_range;

    /**
     * @var string
     */
    protected $observation_code;

    /**
     * @var string
     */
    protected $observation_description;

    /**
     * @var string
     */
    protected $group_code;

    /**
     * @var string
     */
    protected $unit;

    /**
     * @var boolean
     */
    protected $value_is_numeric;

    /**
     * @var string
     */
    protected $comments;

    /**
     * @var array
     */
    protected $rules = array(
        'lab_order' => 'required|integer',
        'document' => 'required|integer',
        'status' => 'required|string',
        'value' => 'required|string'
    );


    public function __construct($lab_order = null, $lab_test = null, $document = null,
                                \DateTime $specimen_received = null, \DateTime $results_released = null, \DateTime $test_performed = null,
                                $status = null, $value = null, $abnormal_status = null, $is_abnormal = null, $normal_range = null,
                                $observation_code = null, $observation_description = null, $group_code = null, $unit = null, $value_is_numeric = null,
                                $comments = null)
    {
        $this->lab_order = $lab_order;
        $this->lab_test = $lab_test;
        $this->document = $document;
        $this->specimen_received = $specimen_received;
        $this->results_released = $results_released;
        $this->test_performed = $test_performed;
        $this->status = $status;
        $this->value = $value;
        $this->abnormal_status = $abnormal_status;
        $this->is_abnormal = $is_abnormal;
        $this->normal_range = $normal_range;
        $this->observation_code = $observation_code;
        $this->observation_description = $observation_description;
        $this->group_code = $group_code;
        $this->unit = $unit;
        $this->value_is_numeric = $value_is_numeric;
        $this->comments = $comments;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'lab_order' => $this->lab_order,
            'lab_test' => $this->lab_test,
            'document' => $this->document,
            'specimen_received' => $this->formatDateTime($this->specimen_received),
            'results_released' => $this->formatDateTime($this->results_released),
            'test_performed' => $this->formatDateTime($this->test_performed),
            'status' => $this->status,
            'value' => $this->value,
            'abnormal_status' => $this->abnormal_status,
            'is_abnormal' => $this->is_abnormal,
            'normal_range' => $this->normal_range,
            'observation_code' => $this->observation_code,
            'observation_description' => $this->observation_description,
            'group_code' => $this->group_code,
            'unit' => $this->unit,
            'value_is_numeric' => $this->value_is_numeric,
            'comments' => $this->comments
        ];
    }

}