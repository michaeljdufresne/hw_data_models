<?php

namespace Edumedics\DataModels\DrChrono\Appointments;

use Edumedics\DataModels\DrChrono\BaseModel;

class AppointmentClinicalNote extends BaseModel
{

    /**
     * @var boolean
     */
    protected $locked;

    /**
     * @var \DateTime
     */
    protected $updated_at;

    /**
     * @var string
     */
    protected $pdf;

    protected $rules = array(
        'locked' => 'required',
        'updated_at' => 'date'
    );

    /**
     * AppointmentClinicalNote constructor.
     * @param bool $locked
     * @param \DateTime $updated_at
     * @param string $pdf
     */
    public function __construct($locked = null, \DateTime $updated_at = null, $pdf = null)
    {
        $this->locked = $locked;
        $this->updated_at = $updated_at;
        $this->pdf = $pdf;
    }

    public function jsonSerialize()
    {
        return[
            'locked' => $this->locked,
            'updated_at' => $this->formatDateTime($this->updated_at),
            'pdf' => $this->pdf
        ];
    }


}