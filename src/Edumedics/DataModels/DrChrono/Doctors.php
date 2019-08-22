<?php

namespace Edumedics\DataModels\DrChrono;

class Doctors extends BaseModel
{

    /**
     * @var string
     */
    protected $country;

    /**
     * @var string
     */
    protected $first_name;

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $last_name;

    /**
     * @var string
     */
    protected $specialty;

    /**
     * @var string
     */
    protected $cell_phone;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $group_npi_number;

    /**
     * @var string
     */
    protected $home_phone;

    /**
     * @var string
     */
    protected $job_title;

    /**
     * @var string
     */
    protected $npi_number;

    /**
     * @var string
     */
    protected $office_phone;

    /**
     * @var integer
     */
    protected $practice_group;

    /**
     * @var string
     */
    protected $suffix;

    /**
     * @var string
     */
    protected $website;

    /**
     * @var array
     */
    protected $rules = array(
        'country' => 'required|string',
        'first_name' => 'required|string',
        'last_name' => 'required|string',
        'specialty' => 'required|string'
    );

    /**
     * Doctors constructor.
     * @param string $country
     * @param string $first_name
     * @param int $id
     * @param string $last_name
     * @param string $specialty
     * @param string $cell_phone
     * @param string $email
     * @param string $group_npi_number
     * @param string $home_phone
     * @param string $job_title
     * @param string $npi_number
     * @param string $office_phone
     * @param int $practice_group
     * @param string $suffix
     * @param string $website
     */
    public function __construct($country = null, $first_name = null, $id = null, $last_name = null, $specialty = null,
                                $cell_phone = null, $email = null, $group_npi_number = null, $home_phone = null,
                                $job_title = null, $npi_number = null, $office_phone = null, $practice_group = null,
                                $suffix = null, $website = null)
    {
        $this->country = $country;
        $this->first_name = $first_name;
        $this->id = $id;
        $this->last_name = $last_name;
        $this->specialty = $specialty;
        $this->cell_phone = $cell_phone;
        $this->email = $email;
        $this->group_npi_number = $group_npi_number;
        $this->home_phone = $home_phone;
        $this->job_title = $job_title;
        $this->npi_number = $npi_number;
        $this->office_phone = $office_phone;
        $this->practice_group = $practice_group;
        $this->suffix = $suffix;
        $this->website = $website;
    }

    public function jsonSerialize()
    {
        return [
            'country' => $this->country,
            'first_name' => $this->first_name,
            'id' => $this->id,
            'last_name' => $this->last_name,
            'specialty' => $this->specialty,
            'cell_phone' => $this->cell_phone,
            'email' => $this->email,
            'group_npi_number' => $this->group_npi_number,
            'home_phone' => $this->home_phone,
            'job_title' => $this->job_title,
            'npi_number' => $this->npi_number,
            'office_phone' => $this->office_phone,
            'practice_group' => $this->practice_group,
            'suffix' => $this->suffix,
            'website' => $this->website
        ];
    }

}