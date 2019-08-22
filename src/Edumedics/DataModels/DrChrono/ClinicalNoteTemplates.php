<?php

namespace Edumedics\DataModels\DrChrono;

use Edumedics\DataModels\DrChrono\ClinicalNoteTemplates\Order;
use Edumedics\DataModels\DrChrono\ClinicalNoteTemplates\TemplateClinicalNoteFields;

class ClinicalNoteTemplates extends BaseModel
{

    /**
     * @var boolean
     */
    protected $archived;

    /**
     * @var integer
     */
    protected $doctor;

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var boolean
     */
    protected $is_onpatient;

    /**
     * @var boolean
     */
    protected $is_persistent;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var Order
     */
    protected $order;

    /**
     * @var TemplateClinicalNoteFields[]
     */
    protected $clinical_note_fields;

    /**
     * @var \DateTime
     */
    protected $updated_at;

    /**
     * @var array
     */
    protected $rules = array(
        'archived' => 'required|boolean',
        'doctor' => 'required|integer',
        'is_onpatient' => 'required|boolean',
        'is_persistent' => 'required|boolean',
        'name' => 'required|string'
    );

    /**
     * ClinicalNoteTemplates constructor.
     * @param bool $archived
     * @param int $doctor
     * @param int $id
     * @param bool $is_onpatient
     * @param bool $is_persistent
     * @param string $name
     * @param Order $order
     * @param TemplateClinicalNoteFields[] $clinical_note_fields
     * @param \DateTime $updated_at
     */
    public function __construct($archived = null, $doctor = null, $id = null, $is_onpatient = null,
                                $is_persistent = null, $name = null, Order $order = null,
                                array $clinical_note_fields = null, \DateTime $updated_at = null)
    {
        $this->archived = $archived;
        $this->doctor = $doctor;
        $this->id = $id;
        $this->is_onpatient = $is_onpatient;
        $this->is_persistent = $is_persistent;
        $this->name = $name;
        $this->order = $order;
        $this->clinical_note_fields = $clinical_note_fields;
        $this->updated_at = $updated_at;
    }

    protected function getSerializedClinicalNoteSections()
    {
        if (!isset($this->clinical_note_fields) || empty($this->clinical_note_fields)) return null;

        $clinicalNoteFields = [];
        foreach ($this->clinical_note_fields as $clinicalNoteField)
        {
            if ($clinicalNoteField instanceof TemplateClinicalNoteFields)
            {
                $clinicalNoteFields[] = $clinicalNoteField->jsonSerialize();
            }
        }

        return empty($clinicalNoteFields) ? null : $clinicalNoteFields;
    }

    public function jsonSerialize()
    {
        return [
            'archived' => $this->archived,
            'doctor' => $this->doctor,
            'id' => $this->id,
            'is_onpatient' => $this->is_onpatient,
            'is_persistent' => $this->is_persistent,
            'name' => $this->name,
            'order' => isset($this->order) ? $this->order->jsonSerialize() : null,
            'clinical_note_fields' => $this->getSerializedClinicalNoteSections(),
            'updated_at' => $this->formatDateTime($this->updated_at)
        ];
    }

}