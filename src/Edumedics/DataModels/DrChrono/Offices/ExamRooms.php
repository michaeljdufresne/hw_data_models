<?php

namespace Edumedics\DataModels\DrChrono\Offices;

use Edumedics\DataModels\DrChrono\BaseModel;

class ExamRooms extends BaseModel
{

    /**
     * @var integer
     */
    protected $index;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var boolean
     */
    protected $online_scheduling;

    /**
     * @var array
     */
    protected $rules = array();

    /**
     * ExamRooms constructor.
     * @param int $index
     * @param string $name
     * @param bool $online_scheduling
     */
    public function __construct($index, $name, $online_scheduling)
    {
        $this->index = $index;
        $this->name = $name;
        $this->online_scheduling = $online_scheduling;
    }


    public function jsonSerialize()
    {
        return [
            'index' => $this->index,
            'name' => $this->name,
            'online_scheduling' => $this->online_scheduling
        ];
    }

}