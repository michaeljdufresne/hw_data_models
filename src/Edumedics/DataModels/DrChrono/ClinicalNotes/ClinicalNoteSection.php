<?php

namespace Edumedics\DataModels\DrChrono\ClinicalNotes;

use Edumedics\DataModels\DrChrono\BaseModel;

class ClinicalNoteSection extends BaseModel
{

    /**
     * @var integer
     */
    protected $clinical_note_template;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var ClinicalNoteSectionFieldValues[]
     */
    protected $values;

    /**
     * @var
     */
    protected $freetext_note;

    /**
     * @var array
     */
    protected $rules = array(
        'clinical_note_template' => 'required|integer',
        'name' => 'required|string'
    );

    /**
     * ClinicalNoteSection constructor.
     * @param int $clinical_note_template
     * @param string $name
     * @param ClinicalNoteSectionFieldValues[] $values
     * @param string $freetext_note
     */
    public function __construct($clinical_note_template = null, $name = null, array $values = array(), $freetext_note = null)
    {
        $this->clinical_note_template = $clinical_note_template;
        $this->name = $name;
        $this->values = $values;
        $this->freetext_note = $freetext_note;
    }

    public function jsonSerialize()
    {
        return [
            'clinical_note_template' => $this->clinical_note_template,
            'name' => $this->name,
            'values' => $this->values,
            'freetext_note' => $this->freetext_note
        ];
    }

}