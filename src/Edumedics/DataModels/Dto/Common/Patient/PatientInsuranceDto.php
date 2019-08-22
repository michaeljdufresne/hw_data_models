<?php


namespace Edumedics\DataModels\Dto\Common\Patient;

use Edumedics\DataModels\Dto\Dto;

/**
 * Class PatientInsuranceDto
 * @package Edumedics\DataModels\Dto\Common\Patient
 * @OA\Schema( schema="PatientInsuranceDto" )
 */
class PatientInsuranceDto extends Dto
{

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $insurance_claim_office_number;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $insurance_company;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $insurance_group_name;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $insurance_group_number;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $insurance_id_number;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $insurance_payer_id;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $insurance_plan_name;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $insurance_plan_type;

    /**
     * @var boolean
     * @OA\Property()
     */
    public $is_subscriber_the_patient;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $patient_relationship_to_subscriber;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $subscriber_address;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $subscriber_city;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $subscriber_country;

    /**
     * @var \DateTime
     * @OA\Property()
     * "Y-m-d\TH:i:s"
     */
    public $subscriber_date_of_birth;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $subscriber_first_name;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $subscriber_gender;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $subscriber_last_name;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $subscriber_middle_name;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $subscriber_social_security;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $subscriber_state;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $subscriber_suffix;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $subscriber_zip_code;

    /**
     * @var string
     * @OA\Property(format="string")
     * base64encoded
     */
    public $photo_front;

    /**
     * @var string
     * @OA\Property(format="string")
     * base64encoded
     */
    public $photo_back;

    /**
     * @var array
     */
    protected $fillable = [
        "insurance_claim_office_number", "insurance_company", "insurance_group_name", "insurance_group_number",
        "insurance_id_number", "insurance_payer_id", "insurance_plan_name", "insurance_plan_type",
        "is_subscriber_the_patient", "patient_relationship_to_subscriber", "subscriber_address", "subscriber_city",
        "subscriber_country", "subscriber_date_of_birth", "subscriber_first_name", "subscriber_gender",
        "subscriber_last_name", "subscriber_middle_name", "subscriber_social_security", "subscriber_state",
        "subscriber_suffix", "subscriber_zip_code", "photo_front", "photo_back"
    ];

    /**
     * @param null $dataArray
     * @return mixed|void
     * @throws \Exception
     */
    public function populate($dataArray = null)
    {
        if (isset($dataArray) && is_array($dataArray))
        {
            foreach ($dataArray as $k => $v)
            {
                switch ($k)
                {
                    case 'subscriber_date_of_birth':
                        $this->{$k} = new \DateTime($v);
                        break;

                    default:
                        $this->{$k} = $v;
                        break;

                }
            }
        }
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            "insurance_claim_office_number" => $this->insurance_claim_office_number,
            "insurance_company" => $this->insurance_company,
            "insurance_group_name" => $this->insurance_group_name,
            "insurance_group_number" => $this->insurance_group_number,
            "insurance_id_number" => $this->insurance_id_number,
            "insurance_payer_id" => $this->insurance_payer_id,
            "insurance_plan_name" => $this->insurance_plan_name,
            "insurance_plan_type" => $this->insurance_plan_type,
            "is_subscriber_the_patient" => $this->is_subscriber_the_patient,
            "patient_relationship_to_subscriber" => $this->patient_relationship_to_subscriber,
            "subscriber_address" => $this->subscriber_address,
            "subscriber_city" => $this->subscriber_city,
            "subscriber_country" => $this->subscriber_country,
            "subscriber_date_of_birth" => $this->formatDateTime($this->subscriber_date_of_birth),
            "subscriber_first_name" => $this->subscriber_first_name,
            "subscriber_gender" => $this->subscriber_gender,
            "subscriber_last_name" => $this->subscriber_last_name,
            "subscriber_middle_name" => $this->subscriber_middle_name,
            "subscriber_social_security" => $this->subscriber_social_security,
            "subscriber_state" => $this->subscriber_state,
            "subscriber_suffix" => $this->subscriber_suffix,
            "subscriber_zip_code" => $this->subscriber_zip_code,
            "photo_front" => $this->photo_front,
            "photo_back" => $this->photo_back
        ];
    }

    /**
     * @param $value
     * @throws \Exception
     */
    public function setSubscriberDateOfBirthAttribute($value)
    {
        if ($value instanceof \DateTime)
        {
            $this->attributes['subscriber_date_of_birth'] = $value->format("Y-m-d\TH:i:s");
        }
        else
        {
            $this->attributes['subscriber_date_of_birth'] = (new \DateTime($value))->format("Y-m-d\TH:i:s");
        }
    }
}