<?php

namespace Edumedics\DataModels\DrChrono;


class SubLabs extends BaseModel
{

    /**
     * @var integer
     */
    protected $id;


    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $facility_code;

    /**
     * @var array
     */
    protected $rules = array(
        'name' => 'required|string',
        'facility_code' => 'required|string'
    );

    /**
     * Sublabs constructor.
     * @param string $name
     * @param string $facility_code
     */
    public function __construct($name, $facility_code)
    {
        $this->name = $name;
        $this->facility_code = $facility_code;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'facility_code' => $this->facility_code
        ];
    }

}