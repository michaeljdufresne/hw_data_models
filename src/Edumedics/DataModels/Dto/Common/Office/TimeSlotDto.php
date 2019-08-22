<?php

namespace Edumedics\DataModels\Dto\Common\Office;


use Edumedics\DataModels\Dto\Dto;

/**
 * Class TimeSlotDto
 * @package Edumedics\DataModels\Dto\Common\Office
 * @OA\Schema( schema="TimeSlotDto" )
 */
class TimeSlotDto extends Dto
{
    const
        Sunday      = 0,
        Monday      = 1,
        Tuesday     = 2,
        Wednesday   = 3,
        Thursday    = 4,
        Friday      = 5,
        Saturday    = 6;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $time_slot_id;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $day;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $hour;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $minute;

    /**
     * @var array
     */
    protected $fillable = ["time_slot_id", "day", "hour", "minute"];

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
                    case 'id':
                        $this->time_slot_id = $v;
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
            "time_slot_id" => $this->time_slot_id,
            "day" => $this->day,
            "hour" => $this->hour,
            "minute" => $this->minute
        ];
    }
}