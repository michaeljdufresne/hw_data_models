<?php

namespace Edumedics\DataModels\DrChrono\Patients;

use Edumedics\DataModels\DrChrono\BaseModel;

class Insurance extends BaseModel
{

    /**
     * @var string
     */
    protected $insurance_claim_office_number;

    /**
     * @var string
     */
    protected $insurance_company;

    /**
     * @var string
     */
    protected $insurance_group_number;

    /**
     * @var string
     */
    protected $insurance_id_number;

    /**
     * @var string
     */
    protected $insurance_payer_id;

    /**
     * @var string
     */
    protected $insurance_plan_name;

    /**
     * @var string
     */
    protected $insurance_plan_type;

    /**
     * @var boolean
     */
    protected $is_subscriber_the_patient;

    /**
     * @var string
     */
    protected $patient_relationship_to_subscriber;

    /**
     * @var string
     */
    protected $subscriber_address;

    /**
     * @var string
     */
    protected $subscriber_city;

    /**
     * @var string
     */
    protected $subscriber_country;

    /**
     * @var \DateTime
     */
    protected $subscriber_date_of_birth;

    /**
     * @var string
     */
    protected $subscriber_first_name;

    /**
     * @var string
     */
    protected $subscriber_gender;

    /**
     * @var string
     */
    protected $subscriber_last_name;

    /**
     * @var string
     */
    protected $subscriber_middle_name;

    /**
     * @var string
     */
    protected $subscriber_social_security;

    /**
     * @var string
     */
    protected $subscriber_state;

    /**
     * @var string
     */
    protected $subscriber_suffix;

    /**
     * @var string
     */
    protected $subscriber_zip_code;

    /**
     * @var string
     */
    protected $photo_front;

    /**
     * @var string
     */
    protected $photo_back;

    public function jsonSerialize()
    {
        return [
            'insurance_claim_office_number' => $this->insurance_claim_office_number,
            'insurance_company' => $this->insurance_company,
            'insurance_group_number' => $this->insurance_group_number,
            'insurance_id_number' => $this->insurance_id_number,
            'insurance_payer_id' => $this->insurance_payer_id,
            'insurance_plan_name' => $this->insurance_plan_name,
            'insurance_plan_type' => $this->insurance_plan_type,
            'is_subscriber_the_patient' => $this->is_subscriber_the_patient,
            'patient_relationship_to_subscriber' => $this->patient_relationship_to_subscriber,
            'subscriber_address' => $this->subscriber_address,
            'subscriber_city' => $this->subscriber_city,
            'subscriber_country' => $this->subscriber_country,
            'subscriber_date_of_birth' => $this->formatDate($this->subscriber_date_of_birth),
            'subscriber_first_name' => $this->subscriber_first_name,
            'subscriber_gender' => $this->subscriber_gender,
            'subscriber_last_name' => $this->subscriber_last_name,
            'subscriber_middle_name' => $this->subscriber_middle_name,
            'subscriber_social_security' => $this->subscriber_social_security,
            'subscriber_state' => $this->subscriber_state,
            'subscriber_suffix' => $this->subscriber_suffix,
            'subscriber_zip_code' => $this->subscriber_zip_code,
            'photo_front' => $this->photo_front,
            'photo_back' => $this->photo_back,
        ];
    }


}