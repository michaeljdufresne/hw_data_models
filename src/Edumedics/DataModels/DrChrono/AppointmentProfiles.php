<?php

namespace Edumedics\DataModels\DrChrono;

class AppointmentProfiles extends BaseModel
{

    /**
     * @var string
     */
    protected $color;

    /**
     * @var integer
     */
    protected $duration;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var boolean
     */
    protected $online_scheduling;

    /**
     * @var string
     */
    protected $reason;

    /**
     * @var integer
     */
    protected $sort_order;

    /**
     * @var boolean
     */
    protected $archived;

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var array
     */
    protected $rules = array();

    /**
     * AppointmentProfiles constructor.
     * @param string $color
     * @param int $duration
     * @param string $name
     * @param bool $online_scheduling
     * @param string $reason
     * @param int $sort_order
     * @param bool $archived
     * @param int $id
     */
    public function __construct($color, $duration, $name, $online_scheduling, $reason, $sort_order, $archived, $id)
    {
        $this->color = $color;
        $this->duration = $duration;
        $this->name = $name;
        $this->online_scheduling = $online_scheduling;
        $this->reason = $reason;
        $this->sort_order = $sort_order;
        $this->archived = $archived;
        $this->id = $id;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'color' => $this->color,
            'duration' => $this->duration,
            'name' => $this->name,
            'online_scheduling' => $this->online_scheduling,
            'reason' => $this->reason,
            'sort_order' => $this->sort_order,
            'archived' => $this->archived,
            'id' => $this->id
        ];
    }
}