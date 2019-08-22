<?php

namespace Edumedics\DataModels\DrChrono;

use Edumedics\DataModels\DrChrono\ClinicalNotes\ClinicalNoteSection;

class ClinicalNotes extends BaseModel
{

    /**
     * @var boolean
     */
    protected $archived;

    /**
     * @var string
     */
    protected $appointment;

    /**
     * @var integer
     */
    protected $patient;

    /**
     * @var ClinicalNoteSection[]
     */
    protected $clinical_note_sections;

    /**
     * @var array
     */
    protected $rules = array(
        'archived' => 'required|boolean',
        'appointment' => 'required|string',
        'patient' => 'required|integer'
    );

    /**
     * ClinicalNotes constructor.
     * @param bool $archived
     * @param string $appointment
     * @param int $patient
     * @param ClinicalNoteSection[] $clinical_note_sections
     */
    public function __construct($archived = null, $appointment = null, $patient = null, array $clinical_note_sections = array())
    {
        $this->archived = $archived;
        $this->appointment = $appointment;
        $this->patient = $patient;
        $this->clinical_note_sections = $clinical_note_sections;
    }

    protected function getSerializedClinicalNoteSections()
    {
        if (!isset($this->clinical_note_sections) || empty($this->clinical_note_sections)) return null;

        $clinicalNoteSections = [];
        foreach ($this->clinical_note_sections as $clinicalNoteSection)
        {
            if ($clinicalNoteSection instanceof ClinicalNoteSection)
            {
                $clinicalNoteSections[] = $clinicalNoteSection->jsonSerialize();
            }
        }

        return empty($clinicalNoteSections) ? null : $clinicalNoteSections;
    }

    public function jsonSerialize()
    {
        return [
            'archived' => $this->archived,
            'appointment' => $this->appointment,
            'patient' => $this->patient,
            'clinical_note_sections' => $this->getSerializedClinicalNoteSections()
        ];
    }

}