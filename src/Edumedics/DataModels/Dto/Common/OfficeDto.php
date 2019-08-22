<?php

namespace Edumedics\DataModels\Dto\Common;

use Edumedics\DataModels\Dto\Dto;

/**
 * Class OfficeDto
 * @package Edumedics\DataModels\Dto\Common
 * @OA\Schema( schema="OfficeDto" )
 */
class OfficeDto extends Dto
{
    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $office_id;

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
    public $phone_number;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $fax_number;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $start_time;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $end_time;

    /**
     * @var bool
     * @OA\Property()
     */
    public $active;

    /**
     * @var array
     */
    protected $fillable = [
        "office_id", "external_ids", "name", "address", "city", "state", "zip_code", "phone_number", "fax_number",
        "start_time", "end_time", "active"
    ];

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
            "office_id" => $this->office_id,
            "external_ids" => $this->jsonSerializeArray($this->external_ids),
            "name" => $this->name,
            "address" => $this->address,
            "city" => $this->city,
            "state" => $this->state,
            "zip_code" => $this->zip_code,
            "phone_number" => $this->phone_number,
            "fax_number" => $this->fax_number,
            "start_time" => $this->start_time,
            "end_time" => $this->end_time,
            "active" => $this->active
        ];
    }
}