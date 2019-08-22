<?php


namespace Edumedics\DataModels\Dto\Common;

use Edumedics\DataModels\Dto\Common\Patient\PatientInsuranceDto;
use Edumedics\DataModels\Dto\Dto;

/**
 * Class PatientDto
 * @package Edumedics\DataModels\Dto\Common
 * @OA\Schema( schema="PatientDto" )
 */
class PatientDto extends Dto
{

    const
        PATIENT_TYPE_EMPLOYEE   = 1,
        PATIENT_TYPE_SPOUSE     = 2,
        PATIENT_TYPE_DEPENDENT  = 3,
        PATIENT_TYPE_RETIREE    = 4,
        PATIENT_TYPE_DP         = 5,
        PATIENT_TYPE_OTHER      = 6;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $patient_id;

    /**
     * @var ExternalIdDto[]
     * @OA\Property()
     */
    public $external_ids;

    /**
     * @var \DateTime
     * @OA\Property()
     * "Y-m-d\TH:i:s"
     */
    public $date_of_birth;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $doctor_id;

    /**
     * @var string
     * @OA\Property(format="string")
     * "Male", "Female"
     */
    public $gender;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $address;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $city;

    /**
     * @var string
     * @OA\Property(format="string")
     * "XX"
     */
    public $state;

    /**
     * @var string
     * @OA\Property(format="string")
     * "XXXXX" or "XXXXX-XXXX"
     */
    public $zip_code;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $ethnicity;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $race;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $first_name;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $last_name;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $middle_name;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $nick_name;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $maiden_name;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $home_phone;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $cell_phone;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $email;

    /**
     * @var PatientInsuranceDto;
     * @OA\Property()
     */
    public $primary_insurance;

    /**
     * @var PatientInsuranceDto;
     * @OA\Property()
     */
    public $secondary_insurance;

    /**
     * @var PatientInsuranceDto;
     * @OA\Property()
     */
    public $tertiary_insurance;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $preferred_language;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $patient_payment_profile;

    /**
     * @var integer
     * @OA\Property(format="integer")
     * Enum 0 = Unarchived, 1 = Archived
     */
    public $archived;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $patient_notes;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $client_id;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $employee_id;

    /**
     * @var integer
     * @OA\Property(format="int64")
     */
    public $type;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $env_config;

    /**
     * @var array
     */
    protected $fillable = [
        "patient_id", "external_ids", "date_of_birth", "doctor_id", "gender", "address", "city", "state", "zip_code",
        "ethnicity", "race", "first_name", "last_name", "middle_name", "nick_name", "maiden_name",
        "home_phone", "cell_phone", "email", "primary_insurance", "secondary_insurance", "tertiary_insurance",
        "preferred_language", "patient_payment_profile", "archived", "patient_notes", "client_id",
        "employee_id", "type", "env_config"
        ];

    /**
     * @var array
     */
    protected $externalIdTempMap = [
        'drchrono_patient_id' => ExternalIdDto::DrChronoId,
        'navmd_id' => ExternalIdDto::NavMdId
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
            $insuranceData = [];
            foreach ($dataArray as $k => $v)
            {
                switch ($k)
                {
                    case '_id':
                        $this->patient_id = $v;
                        break;

                    case 'date_of_birth':
                        $this->{$k} = new \DateTime($v);
                        break;

                    case 'external_ids':
                        $this->{$k} = [];
                        foreach ($v as $externalId)
                        {
                            $externalIdDto = new ExternalIdDto();
                            $externalIdDto->populate($externalId);
                            $this->{$k}[] = $externalIdDto;
                        }
                        break;

                    case 'drchrono_patient_id':
                    case 'navmd_id':
                        if (!empty($v))
                        {
                            $externalIdDto = new ExternalIdDto();
                            $externalIdDto->fill([
                                'id' => $v,
                                'type' => $this->externalIdTempMap[$k]
                            ]);
                            $this->external_ids[] = $externalIdDto;
                        }
                        break;

                    case 'doctor':
                        $this->doctor_id = $v;
                        break;

                    case 'primary_insurance':
                    case 'secondary_insurance':
                    case 'tertiary_insurance':
                        if (!empty($v))
                        {
                            $patientInsuranceDto = new PatientInsuranceDto();
                            $patientInsuranceDto->populate($v);
                            $this->{$k} = $patientInsuranceDto;
                        }
                        break;

                    case 'insurance_company':
                    case 'insurance_id_number':
                    case 'insurance_group_number':
                        $insuranceData[$k] = $v;
                        break;

                    default:
                        $this->{$k} = $v;
                        break;

                }
            }
            $this->fillInsuranceObject($insuranceData);
        }
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            "patient_id" => $this->patient_id,
            "external_ids" => $this->jsonSerializeArray($this->external_ids),
            "date_of_birth" => $this->formatDateTime($this->date_of_birth),
            "doctor_id" => $this->doctor_id,
            "gender" => $this->gender,
            "address" => $this->address,
            "city" => $this->city,
            "state" => $this->state,
            "zip_code" => $this->zip_code,
            "ethnicity" => $this->ethnicity,
            "race" => $this->race,
            "first_name" => $this->first_name,
            "last_name" => $this->last_name,
            "middle_name" => $this->middle_name,
            "nick_name" => $this->nick_name,
            "maiden_name" => $this->maiden_name,
            "home_phone" => $this->home_phone,
            "cell_phone" => $this->cell_phone,
            "email" => $this->email,
            "primary_insurance" => $this->jsonSerializeObject($this->primary_insurance),
            "secondary_insurance" => $this->jsonSerializeObject($this->secondary_insurance),
            "tertiary_insurance" => $this->jsonSerializeObject($this->tertiary_insurance),
            "preferred_language" => $this->preferred_language,
            "patient_payment_profile" => $this->patient_payment_profile,
            "archived" => $this->archived,
            "patient_notes" => $this->patient_notes,
            "client_id" => $this->client_id,
            "employee_id" => $this->employee_id,
            "type" => $this->type,
            "env_config" => $this->env_config
        ];
    }

    /**
     * @param $value
     * @throws \Exception
     */
    public function setDateOfBirthAttribute($value)
    {
        if ($value instanceof \DateTime)
        {
            $this->attributes['date_of_birth'] = $value->format("Y-m-d\TH:i:s");
        }
        else
        {
            $this->attributes['date_of_birth'] = (new \DateTime($value))->format("Y-m-d\TH:i:s");
        }
    }

    /**
     * @param $insuranceData
     */
    protected function fillInsuranceObject($insuranceData)
    {
        if (count($insuranceData) > 0)
        {
            $patientInsuranceDto = new PatientInsuranceDto();
            $patientInsuranceDto->fill($insuranceData);
            if (!isset($this->primary_insurance))
            {
                $this->primary_insurance = $patientInsuranceDto;
            }
            elseif(!isset($this->secondary_insurance))
            {
                $this->secondary_insurance = $patientInsuranceDto;
            }
            elseif (!isset($this->tertiary_insurance))
            {
                $this->tertiary_insurance = $patientInsuranceDto;
            }
        }
    }

}