<?php

namespace Edumedics\DataModels\DrChrono\Appointments;

use Edumedics\DataModels\DrChrono\BaseModel;

class Reminder extends BaseModel
{

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var \DateTime
     */
    protected $scheduled_time;

    /**
     * @var string
     */
    private $type;

    protected $rules = array(
        'id' => 'integer',
        'scheduled_time' => 'date'
    );

    /**
     * Reminder constructor.
     * @param int $id
     * @param \DateTime $scheduled_time
     * @param string $type
     */
    public function __construct($id = null, \DateTime $scheduled_time = null, $type = null)
    {
        $this->id = $id;
        $this->scheduled_time = $scheduled_time;
        $this->type = $type;
    }

    public function jsonSerialize()
    {
        return[
            'id' => $this->id,
            'scheduled_time' => $this->formatDateTime($this->scheduled_time),
            'type' => $this->type
        ];
    }

}