<?php

namespace Edumedics\DataModels\DrChrono\ClinicalNoteTemplates;

use Edumedics\DataModels\DrChrono\BaseModel;

class Order extends BaseModel
{

    /**
     * @var integer
     */
    protected $on_ipad;

    /**
     * @var integer
     */
    protected $on_complete_note;

    /**
     * @var array
     */
    protected $rules = array(
        'on_ipad' => 'required|integer',
        'on_complete_note' => 'required|integer'
    );

    /**
     * Order constructor.
     * @param int $on_ipad
     * @param int $on_complete_note
     */
    public function __construct($on_ipad = null, $on_complete_note = null)
    {
        $this->on_ipad = $on_ipad;
        $this->on_complete_note = $on_complete_note;
    }

    public function jsonSerialize()
    {
        return [
            'on_ipad' => $this->on_ipad,
            'on_complete_note' => $this->on_complete_note
        ];
    }

}