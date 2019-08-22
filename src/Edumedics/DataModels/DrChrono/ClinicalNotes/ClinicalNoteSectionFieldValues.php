<?php

namespace Edumedics\DataModels\DrChrono\ClinicalNotes;

use Edumedics\DataModels\DrChrono\BaseModel;

class ClinicalNoteSectionFieldValues extends BaseModel
{

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var integer
     */
    protected $clinical_note_field;

    /**
     * @var string
     */
    protected $appointment;

    /**
     * @var string
     */
    protected $value;

    /**
     * @var array
     */
    protected $rules = array(
        'id' => 'required|integer',
        'clinical_note_field' => 'required|integer',
        'value' => 'required|string'
    );

    /**
     * ClinicalNoteSectionFieldValues constructor.
     * @param int $id
     * @param int $clinical_note_field
     * @param string $value
     * @param string $appointment
     */
    public function __construct($id = null, $clinical_note_field = null, $value = null, $appointment = null)
    {
        $this->id = $id;
        $this->clinical_note_field = $clinical_note_field;
        $this->value = $value;
        $this->appointment = $appointment;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'clinical_note_field' => $this->clinical_note_field,
            'value' => $this->value,
            'appointment' => $this->appointment
        ];
    }

}