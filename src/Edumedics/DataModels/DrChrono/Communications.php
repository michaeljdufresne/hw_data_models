<?php

namespace Edumedics\DataModels\DrChrono;

class Communications extends BaseModel
{

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var integer
     */
    protected $patient;

    /**
     * @var integer
     */
    protected $doctor;

    /**
     * @var string
     */
    protected $appointment;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var \DateTime
     */
    protected $scheduled_time;

    /**
     * @var integer
     */
    protected $duration;

    /**
     * @var string
     */
    protected $cash_charged;

    /**
     * @var string
     */
    protected $message;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var boolean
     */
    protected $archived;

    /**
     * @var string
     */
    protected $author;

    /**
     * @var \DateTime
     */
    protected $created_at;

    /**
     * @var \DateTime
     */
    protected $updated_at;

    /**
     * @var array
     */
    protected $rules = array();

    /**
     * Communications constructor.
     * @param int $patient
     * @param int $doctor
     * @param string $appointment
     * @param string $title
     * @param \DateTime $scheduled_time
     * @param int $duration
     * @param string $cash_charged
     * @param string $message
     * @param string $type
     * @param bool $archived
     * @param string $author
     */
    public function __construct($patient = null, $doctor = null, $appointment = null, $title = null, \DateTime $scheduled_time = null,
                                $duration = null, $cash_charged = null, $message = null, $type = null, $archived = null, $author = null)
    {
        $this->patient = $patient;
        $this->doctor = $doctor;
        $this->appointment = $appointment;
        $this->title = $title;
        $this->scheduled_time = $scheduled_time;
        $this->duration = $duration;
        $this->cash_charged = $cash_charged;
        $this->message = $message;
        $this->type = $type;
        $this->archived = $archived;
        $this->author = $author;
    }


    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'patient' => $this->patient,
            'doctor' => $this->doctor,
            'appointment' => $this->appointment,
            'title' => $this->title,
            'scheduled_time' => $this->scheduled_time,
            'duration' => $this->duration,
            'cash_charged' => $this->cash_charged,
            'message' => $this->message,
            'type' => $this->type,
            'archived' => $this->archived,
            'author' => $this->author,
            'created_at' => $this->formatDateTime($this->created_at),
            'updated_at' => $this->formatDateTime($this->updated_at)
        ];
    }

}