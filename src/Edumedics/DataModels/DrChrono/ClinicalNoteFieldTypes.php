<?php

namespace Edumedics\DataModels\DrChrono;

class ClinicalNoteFieldTypes extends BaseModel
{

    /**
     * @var boolean
     */
    protected $archived;

    /**
     * @var integer
     */
    protected $appointment;

    /**
     * @var integer
     */
    protected $clinical_note_template;

    /**
     * @var string
     * One of "", "Checkbox", "NullCheckbox", "String", "TwoStrings", "FreeDraw", "Photo", "Header", "Subheader"
     */
    protected $data_type;

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var boolean
     */
    protected $required;

    /**
     * @var string
     */
    protected $comment;

    /**
     * @var array
     */
    protected $rules = array(
        'archived' => 'required|boolean',
        'appointment' => 'required|integer',
        'clinical_note_template' => 'required|template',
        'data_type' => 'required|string',
        'name' => 'required|string',
        'required' => 'required|boolean'
    );

    /**
     * ClinicalNoteFieldTypes constructor.
     * @param bool $archived
     * @param int $appointment
     * @param int $clinical_note_template
     * @param string $data_type
     * @param int $id
     * @param string $name
     * @param bool $required
     * @param string $comment
     */
    public function __construct($archived = null, $appointment = null, $clinical_note_template = null,
                                $data_type = null, $id = null, $name = null, $required = null, $comment = null)
    {
        $this->archived = $archived;
        $this->appointment = $appointment;
        $this->clinical_note_template = $clinical_note_template;
        $this->data_type = $data_type;
        $this->id = $id;
        $this->name = $name;
        $this->required = $required;
        $this->comment = $comment;
    }

    public function jsonSerialize()
    {
        return [
            'archived' => $this->archived,
            'appointment' => $this->appointment,
            'clinical_note_template' => $this->clinical_note_template,
            'data_type' => $this->data_type,
            'id' => $this->id,
            'name' => $this->name,
            'required' => $this->required,
            'comment' => $this->comment
        ];
    }

}