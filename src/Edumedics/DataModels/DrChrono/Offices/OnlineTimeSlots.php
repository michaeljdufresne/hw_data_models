<?php

namespace Edumedics\DataModels\DrChrono\Offices;

use Edumedics\DataModels\DrChrono\BaseModel;

class OnlineTimeSlots extends BaseModel
{

    /**
     * @var integer
     */
    protected $day;

    /**
     * @var integer
     */
    protected $hour;

    /**
     * @var integer
     */
    protected $minute;

    /**
     * @var array
     */
    protected $rules = array();

    /**
     * OnlineTimeSlots constructor.
     * @param int $day
     * @param int $hour
     * @param int $minute
     */
    public function __construct($day, $hour, $minute)
    {
        $this->day = $day;
        $this->hour = $hour;
        $this->minute = $minute;
    }

    public function jsonSerialize()
    {
        return [
            'day' => $this->day,
            'hour' => $this->hour,
            'minute' => $this->minute
        ];
    }

}