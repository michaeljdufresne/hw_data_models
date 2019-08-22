<?php

namespace Edumedics\DataModels\DrChrono\ClinicalNoteTemplates;

use Edumedics\DataModels\DrChrono\BaseModel;

class TemplateClinicalNoteFields extends BaseModel
{

    /**
     * @var boolean
     */
    protected $archived;

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
        'data_type' => 'required|string',
        'name' => 'required|string',
        'required' => 'required|boolean',
    );

    /**
     * TemplateClinicalNoteFields constructor.
     * @param bool $archived
     * @param string $data_type
     * @param int $id
     * @param string $name
     * @param bool $required
     * @param string $comment
     */
    public function __construct($archived = null, $data_type = null, $id = null,
                                $name = null, $required = null, $comment = null)
    {
        $this->archived = $archived;
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
            'data_type' => $this->data_type,
            'id' => $this->id,
            'name' => $this->name,
            'required' => $this->required,
            'comment' => $this->comment
        ];
    }

}