<?php


namespace Edumedics\DataModels\DrChrono;

class Documents extends BaseModel
{

    /**
     * @var \DateTime
     */
    protected $date;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var integer
     */
    protected $doctor;

    /**
     * @var string
     */
    protected $document;

    /**
     * @var integer
     */
    protected $patient;

    /**
     * @var string[]
     */
    protected $metatags;

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var \DateTime
     */
    protected $updated_at;

    /**
     * @var array
     */
    protected $rules = array(
        'date' => 'required',
        'description' => 'required|string',
        'doctor' => 'required|integer',
        'document' => 'required|string',
        'patient' => 'required|integer'
    );

    /**
     * Documents constructor.
     * @param \DateTime $date
     * @param string $description
     * @param int $doctor
     * @param string $document
     * @param int $patient
     * @param \string[] $metatags
     * @param int $id
     * @param \DateTime $updated_at
     */
    public function __construct(\DateTime $date = null, $description = null, $doctor = null, $document = null,
                                $patient = null, array $metatags = null, $id = null, \DateTime $updated_at = null)
    {
        $this->date = $date;
        $this->description = $description;
        $this->doctor = $doctor;
        $this->document = $document;
        $this->patient = $patient;
        $this->metatags = $metatags;
        $this->id = $id;
        $this->updated_at = $updated_at;
    }

    public function jsonSerialize()
    {
        return [
            'date' => $this->formatDate($this->date),
            'description' => $this->description,
            'doctor' => $this->doctor,
            'document' => $this->document,
            'patient' => $this->patient,
            'metatags' => $this->metatags,
            'id' => $this->id,
            'updated_at' => $this->formatDateTime($this->updated_at)
        ];
    }

    public function getMultipartDataFields()
    {
        return [
            [
                'name'     => 'date',
                'contents' => $this->formatDate($this->date)
            ],
            [
                'name'     => 'description',
                'contents' => $this->description
            ],
            [
                'name'     => 'doctor',
                'contents' => $this->doctor
            ],
            [
                'name'     => 'patient',
                'contents' => $this->patient
            ]
        ];
    }

}