<?php

namespace Edumedics\DataModels\DrChrono\Patients;

use Edumedics\DataModels\DrChrono\BaseModel;

class PatientCustomDemographic extends BaseModel
{

    /**
     * @var string
     */
    protected $value;

    /**
     * @var integer
     */
    protected $field_type;

    /**
     * @var array
     */
    protected $rules = array(
        'value' => 'required|string',
        'field_type' => 'required|integer'
    );

    /**
     * PatientCustomDemographic constructor.
     * @param string $value
     * @param int $field_type
     */
    public function __construct($value = null, $field_type = null)
    {
        $this->value = $value;
        $this->field_type = $field_type;
    }

    public function jsonSerialize()
    {
        return [
            'value' => $this->value,
            'field_type' => $this->field_type
        ];
    }


}