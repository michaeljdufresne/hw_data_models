<?php

namespace Edumedics\DataModels\DrChrono\LabOrders;

use Edumedics\DataModels\DrChrono\BaseModel;

class ICD10Code extends BaseModel
{

    /**
     * @var string
     */
    protected $code;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var array
     */
    protected $rules = array();

    /**
     * ICD10Code constructor.
     * @param string $code
     * @param string $description
     */
    public function __construct($code = null, $description = null)
    {
        $this->code = $code;
        $this->description = $description;
    }

    public function jsonSerialize()
    {
        return [
            'code' => $this->code,
            'description' => $this->description
        ];
    }

}

