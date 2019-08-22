<?php

namespace Edumedics\DataModels\DrChrono;

class PatientSummary extends BaseModel
{

    /**
     * @var \DateTime
     */
    protected $date_of_birth;

    /**
     * @var integer
     */
    protected $doctor;

    /**
     * @var string
     */
    protected $gender;

    /**
     * @var string
     */
    protected $chart_id;

    /**
     * @var string
     */
    protected $first_name;

    /**
     * @var string
     */
    protected $last_name;

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var array
     */
    protected $rules = array(
        'doctor' => 'required|integer',
        'gender' => 'required|string'
    );

    /**
     * Patients constructor.
     * @param \DateTime $date_of_birth
     * @param int $doctor
     * @param string $gender
     * @param string $chart_id
     * @param string $first_name
     * @param string $last_name
     * @param int $id
     */
    public function __construct(\DateTime $date_of_birth = null, $doctor = null, $gender = null,
                                $chart_id = null, $first_name = null, $last_name = null, $id = null)
    {
        $this->date_of_birth = $date_of_birth;
        $this->doctor = $doctor;
        $this->gender = $gender;
        $this->chart_id = $chart_id;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->id = $id;
    }

    public function jsonSerialize()
    {
        return [
            'date_of_birth' => $this->formatDate($this->date_of_birth),
            'doctor' => $this->doctor,
            'gender' => $this->gender,
            'chart_id' => $this->chart_id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'id' => $this->id
        ];
    }

}