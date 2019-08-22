<?php

namespace Edumedics\DataModels\DrChrono;

use Edumedics\DataModels\DrChrono\Offices\ExamRooms;
use Edumedics\DataModels\DrChrono\Offices\OnlineTimeSlots;

class Offices extends BaseModel
{

    /**
     * @var boolean
     */
    protected $online_scheduling;

    /**
     * @var array
     */
    protected $online_timeslots;

    /**
     * @var string
     */
    protected $address;

    /**
     * @var boolean
     */
    protected $archived;

    /**
     * @var string
     */
    protected $city;

    /**
     * @var string
     */
    protected $country;

    /**
     * @var integer
     */
    protected $doctor;

    /**
     * @var \DateTime
     */
    protected $end_time;

    /**
     * @var array
     */
    protected $exam_rooms;

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $phone_number;

    /**
     * @var string
     */
    protected $fax_number;

    /**
     * @var \DateTime
     */
    protected $start_time;

    /**
     * @var string
     */
    protected $state;

    /**
     * @var string
     */
    protected $zip_code;

    /**
     * @var array
     */
    protected $rules = array();

    /**
     * Offices constructor.
     * @param bool $online_scheduling
     * @param array $online_timeslots
     * @param string $address
     * @param bool $archived
     * @param string $city
     * @param string $country
     * @param int $doctor
     * @param \DateTime $end_time
     * @param array $exam_rooms
     * @param int $id
     * @param string $name
     * @param string $phone_number
     * @param string $fax_number
     * @param \DateTime $start_time
     * @param string $state
     * @param string $zip_code
     * @param array $rules
     */
    public function __construct($online_scheduling, array $online_timeslots, $address, $archived, $city,
                                $country, $doctor, \DateTime $end_time, array $exam_rooms, $id, $name, $phone_number,
                                $fax_number, \DateTime $start_time, $state, $zip_code, array $rules)
    {
        $this->online_scheduling = $online_scheduling;
        $this->online_timeslots = $online_timeslots;
        $this->address = $address;
        $this->archived = $archived;
        $this->city = $city;
        $this->country = $country;
        $this->doctor = $doctor;
        $this->end_time = $end_time;
        $this->exam_rooms = $exam_rooms;
        $this->id = $id;
        $this->name = $name;
        $this->phone_number = $phone_number;
        $this->fax_number = $fax_number;
        $this->start_time = $start_time;
        $this->state = $state;
        $this->zip_code = $zip_code;
    }

    /**
     * @return array|null
     */
    protected function getSerializedOnlineTimeslots()
    {
        if (!isset($this->online_timeslots) || empty($this->online_timeslots)) return null;

        $onlineTimeslots = [];
        foreach ($this->online_timeslots as $onlineTimeslot)
        {
            if ($onlineTimeslot instanceof OnlineTimeSlots)
            {
                $onlineTimeslots[] = $onlineTimeslot->jsonSerialize();
            }
        }

        return empty($onlineTimeslots) ? null : $onlineTimeslots;
    }

    /**
     * @return array|null
     */
    protected function getSerializedExamRooms()
    {
        if (!isset($this->exam_rooms) || empty($this->exam_rooms)) return null;

        $examRooms = [];
        foreach ($this->exam_rooms as $examRoom)
        {
            if ($examRoom instanceof ExamRooms)
            {
                $examRooms[] = $examRoom->jsonSerialize();
            }
        }

        return empty($examRooms) ? null : $examRooms;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'online_scheduling' => $this->country,
            'online_timeslots' => $this->getSerializedOnlineTimeslots(),
            'address' => $this->address,
            'archived' => $this->archived,
            'city' => $this->city,
            'country' => $this->country,
            'doctor' => $this->doctor,
            'end_time' => $this->formatDateTime($this->end_time),
            'exam_rooms' => $this->getSerializedExamRooms(),
            'id' => $this->id,
            'name' => $this->name,
            'phone_number' => $this->phone_number,
            'fax_number' => $this->fax_number,
            'start_time' => $this->formatDateTime($this->start_time),
            'state' => $this->state,
            'zip_code' => $this->zip_code
        ];
    }

}