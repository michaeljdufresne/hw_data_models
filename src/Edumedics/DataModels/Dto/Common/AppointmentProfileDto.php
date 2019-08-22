<?php

namespace Edumedics\DataModels\Dto\Common;


use Edumedics\DataModels\Dto\Dto;


/**
 * Class AppointmentProfileDto
 * @package Edumedics\DataModels\Dto\Common
 * @OA\Schema( schema="AppointmentProfileDto" )
 */
class AppointmentProfileDto extends Dto
{

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $appointment_profile_id;

    /**
     * @var ExternalIdDto[]
     * @OA\Property()
     */
    public $external_ids;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $name;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $description;

    /**
     * @var bool
     * @OA\Property()
     */
    public $active;

    /**
     * @var array
     */
    protected $fillable = ["appointment_profile_id", "external_ids", "name", "description"];

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
            "appointment_profile_id" => $this->doctor_id,
            "external_ids" => $this->jsonSerializeArray($this->external_ids),
            "name" => $this->name,
            "description" => $this->description,
            "active" => $this->active
        ];
    }
}