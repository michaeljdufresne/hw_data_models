<?php
/**
 * Created by IntelliJ IDEA.
 * User: DennisHolland
 * Date: 2019-07-29
 * Time: 14:16
 */

namespace Edumedics\DataModels\Dto\Common;


use Edumedics\DataModels\Dto\Dto;

/**
 * Class DoctorDto
 * @package Edumedics\DataModels\Dto\Common
 * @OA\Schema( schema="DoctorDto" )
 */
class DoctorDto extends Dto
{

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $doctor_id;

    /**
     * @var ExternalIdDto[]
     * @OA\Property()
     */
    public $external_ids;

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
    public $suffix;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $specialty;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $group_npi_number;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $npi_number;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $practice_group_name;

    /**
     * @var bool
     * @OA\Property()
     */
    public $active;

    /**
     * @var array
     */
    protected $fillable = ["doctor_id", "external_ids", "first_name", "last_name", "suffix", "specialty",
        "group_npi_number", "npi_number", "practice_group_name"];

    /**
     * @param null $dataArray
     * @return mixed|void
     */
    public function populate($dataArray = null)
    {
        if (isset($dataArray) && is_array($dataArray))
        {
            foreach ($dataArray as $k => $v)
            {
                switch ($k)
                {
                    case 'external_ids':
                        $this->{$k} = [];
                        foreach ($v as $externalId)
                        {
                            $externalIdDto = new ExternalIdDto();
                            $externalIdDto->populate($externalId);
                            $this->{$k}[] = $externalIdDto;
                        }
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
            "doctor_id" => $this->doctor_id,
            "external_ids" => $this->jsonSerializeArray($this->external_ids),
            "first_name" => $this->first_name,
            "last_name" => $this->last_name,
            "suffix" => $this->suffix,
            "specialty" => $this->specialty,
            "group_npi_number" => $this->group_npi_number,
            "npi_number" => $this->npi_number,
            "practice_group_name" => $this->practice_group_name,
            "active" => $this->active
        ];
    }
}