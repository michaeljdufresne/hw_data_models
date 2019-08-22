<?php

namespace Edumedics\DataModels\DrChrono\Appointments;

use Edumedics\DataModels\DrChrono\BaseModel;

class CustomVital extends BaseModel
{

    /**
     * @var string
     */
    protected $value;

    /**
     * @var integer
     */
    protected $vital_type;

    protected $rules = array(
        'value' => 'required',
        'vital_type' => 'required|integer'
    );

    /**
     * CustomVital constructor.
     * @param string $value
     * @param int $vital_type
     */
    public function __construct($value = null, $vital_type = null)
    {
        $this->value = $value;
        $this->vital_type = $vital_type;
    }

    public function jsonSerialize()
    {
        return [
            'value' => $this->value,
            'vital_type' => $this->vital_type
        ];
    }


}