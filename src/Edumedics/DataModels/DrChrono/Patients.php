<?php

namespace Edumedics\DataModels\DrChrono;

use Edumedics\DataModels\DrChrono\Patients\Insurance;
use Edumedics\DataModels\DrChrono\Patients\PatientCustomDemographic;

class Patients extends BaseModel
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
    protected $address;

    /**
     * @var string
     */
    protected $cell_phone;

    /**
     * @var string
     */
    protected $chart_id;

    /**
     * @var string
     */
    protected $city;

    /**
     * @var PatientCustomDemographic[]
     */
    protected $custom_demographics;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $emergency_contact_name;

    /**
     * @var string
     */
    protected $emergency_contact_phone;

    /**
     * @var string
     */
    protected $emergency_contact_relation;

    /**
     * @var string
     */
    protected $employer;

    /**
     * @var string
     */
    protected $employer_address;

    /**
     * @var string
     */
    protected $employer_city;

    /**
     * @var string
     */
    protected $employer_state;

    /**
     * @var string
     */
    protected $employer_zip_code;

    /**
     * @var string
     */
    protected $ethnicity;

    /**
     * @var string
     */
    protected $first_name;

    /**
     * @var string
     */
    protected $home_phone;

    /**
     * @var string
     */
    protected $last_name;

    /**
     * @var string
     */
    protected $middle_name;


    /**
     * @var string
     */
    protected $nick_name;
    /**
     * @var string
     */
    protected $preferred_language;

    /**
     * @var string
     */
    protected $patient_photo;

    /**
     * @var \DateTime
     */
    protected $patient_photo_date;

    /**
     * @var string
     */
    protected $primary_care_physician;

    /**
     * @var Insurance
     */
    protected $primary_insurance;

    /**
     * @var string
     */
    protected $race;

    /**
     * @var string
     */
    protected $responsible_party_name;

    /**
     * @var string
     */
    protected $responsible_party_relation;

    /**
     * @var string
     */
    protected $responsible_party_phone;

    /**
     * @var string
     */
    protected $responsible_party_email;

    /**
     * @var Insurance
     */
    protected $secondary_insurance;

    /**
     * @var string
     */
    protected $social_security_number;

    /**
     * @var string
     */
    protected $state;

    /**
     * @var Insurance
     */
    protected $tertiary_insurance;

    /**
     * @var string
     */
    protected $zip_code;

    /**
     * @var \DateTime
     */
    protected $date_of_first_appointment;

    /**
     * @var \DateTime
     */
    protected $date_of_last_appointment;

    /**
     * @var string
     */
    protected $copay;

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var integer[]
     */
    protected $offices;

    /**
     * @var \DateTime
     */
    protected $updated_at;

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
     * @param string $address
     * @param string $cell_phone
     * @param string $city
     * @param string $ethnicity
     * @param string $first_name
     * @param string $home_phone
     * @param string $last_name
     * @param string $middle_name
     * @param string $nick_name
     * @param string $primary_care_physician
     * @param Insurance $primary_insurance
     * @param string $race
     * @param string $social_security_number
     * @param string $state
     * @param string $zip_code
     */
    public function __construct(\DateTime $date_of_birth = null, $doctor= null, $gender= null, $address= null, $cell_phone= null, $city= null, $ethnicity= null,
                                $first_name= null, $home_phone= null, $last_name= null, $middle_name= null, $nick_name = null, $primary_care_physician= null,
                                Insurance $primary_insurance= null, $race= null, $social_security_number= null, $state= null, $zip_code= null)
    {
        $this->date_of_birth = $date_of_birth;
        $this->doctor = $doctor;
        $this->gender = $gender;
        $this->address = $address;
        $this->cell_phone = $cell_phone;
        $this->city = $city;
        $this->ethnicity = $ethnicity;
        $this->first_name = $first_name;
        $this->home_phone = $home_phone;
        $this->last_name = $last_name;
        $this->middle_name = $middle_name;
        $this->nick_name = $nick_name;
        $this->primary_care_physician = $primary_care_physician;
        $this->primary_insurance = $primary_insurance;
        $this->race = $race;
        $this->social_security_number = $social_security_number;
        $this->state = $state;
        $this->zip_code = $zip_code;
    }

    protected function getSerializedCustomDemographics()
    {
        if (!isset($this->custom_demographics) || empty($this->custom_demographics)) return null;

        $customDemographics = [];
        foreach ($this->custom_demographics as $customDemographic)
        {
            if ($customDemographic instanceof PatientCustomDemographic)
            {
                $customDemographics[] = $customDemographic->jsonSerialize();
            }
        }

        return empty($customDemographics) ? null : $customDemographics;
    }

    public function jsonSerialize()
    {
        return [
            'date_of_birth' => $this->formatDate($this->date_of_birth),
            'doctor' => $this->doctor,
            'gender' => $this->gender,
            'address' => $this->address,
            'cell_phone' => $this->cell_phone,
            'chart_id' => $this->chart_id,
            'city' => $this->city,
            'custom_demographics' => $this->getSerializedCustomDemographics(),
            'email' => $this->email,
            'emergency_contact_name' => $this->emergency_contact_name,
            'emergency_contact_phone' => $this->emergency_contact_phone,
            'emergency_contact_relation' => $this->emergency_contact_relation,
            'employer' => $this->employer,
            'employer_address' => $this->employer_address,
            'employer_city' => $this->employer_city,
            'employer_state' => $this->employer_state,
            'employer_zip_code' => $this->employer_zip_code,
            'ethnicity' => $this->ethnicity,
            'first_name' => $this->first_name,
            'home_phone' => $this->home_phone,
            'last_name' => $this->last_name,
            'middle_name' => $this->middle_name,
            'nick_name' => $this->nick_name,
            'preferred_language' => $this->preferred_language,
            'patient_photo' => $this->patient_photo,
            'patient_photo_date' => $this->formatDate($this->patient_photo_date),
            'primary_care_physician' => $this->primary_care_physician,
            'primary_insurance' => isset($this->primary_insurance) ? $this->primary_insurance->jsonSerialize() : null,
            'race' => $this->race,
            'responsible_party_name' => $this->responsible_party_name,
            'responsible_party_relation' => $this->responsible_party_relation,
            'responsible_party_phone' => $this->responsible_party_phone,
            'responsible_party_email' => $this->responsible_party_email,
            'secondary_insurance' => isset($this->secondary_insurance) ? $this->secondary_insurance->jsonSerialize() : null,
            'social_security_number' => $this->social_security_number,
            'state' => $this->state,
            'tertiary_insurance' => isset($this->tertiary_insurance) ? $this->tertiary_insurance->jsonSerialize() : null,
            'zip_code' => $this->zip_code,
            'date_of_first_appointment' => $this->formatDate($this->date_of_first_appointment),
            'date_of_last_appointment' => $this->formatDate($this->date_of_last_appointment),
            'copay' => $this->copay,
            'id' => $this->id,
            'offices' => $this->offices,
            'updated_at' => $this->formatDateTime($this->updated_at)
            ];
    }


}