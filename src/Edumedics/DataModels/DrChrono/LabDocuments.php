<?php

namespace Edumedics\DataModels\DrChrono;

class LabDocuments extends BaseModel
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var integer
     */
    protected $lab_order;

    /**
     * @var string
     */
    protected $document;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var \DateTime
     */
    protected $timestamp;

    /**
     * @var array
     */
    protected $rules = array(
        'lab_order' => 'required|integer',
        'type' => 'required|string'
    );

    /**
     * LabDocuments constructor.
     * @param int $lab_order
     * @param string $document
     * @param string $type
     * @param \DateTime $timestamp
     */
    public function __construct($lab_order = null, $document = null, $type = null, \DateTime $timestamp = null)
    {
        $this->lab_order = $lab_order;
        $this->document = $document;
        $this->type = $type;
        $this->timestamp = $timestamp;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'lab_order' => $this->lab_order,
            'document' => $this->document,
            'type' => $this->type,
            'timestamp' => $this->formatDateTime($this->timestamp)
        ];
    }

    public function getMultipartDataFields()
    {
        return [
            [
                'name'     => 'lab_order',
                'contents' => $this->lab_order
            ],
            [
                'name'     => 'type',
                'contents' => $this->type
            ],
            [
                'name'     => 'timestamp',
                'contents' => $this->formatDateTime($this->timestamp)
            ]
        ];
    }

}