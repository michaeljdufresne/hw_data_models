<?php

namespace Edumedics\DataModels\DrChrono;

class CustomVitals extends BaseModel
{

    /**
     * @var boolean
     */
    protected $archived;

    /**
     * @var string
     */
    protected $data_type;

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
    protected $is_fraction_field;

    /**
     * @var string[]
     */
    protected $allowed_values;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $fraction_delimiter;

    /**
     * @var string
     */
    protected $unit;

    /**
     * @var array
     */
    protected $rules = array(
        'archived' => 'required|boolean',
        'data_type' => 'required|string',
        'doctor' => 'required|integer',
        'is_fractional_field' => 'required|boolean',
        'name' => 'required|string'
    );

    /**
     * CustomVitals constructor.
     * @param bool $archived
     * @param string $data_type
     * @param int $doctor
     * @param int $id
     * @param bool $is_fraction_field
     * @param \string[] $allowed_values
     * @param string $description
     * @param string $fraction_delimiter
     * @param string $unit
     */
    public function __construct($archived = null, $data_type = null, $doctor = null, $id = null,
                                $is_fraction_field = null, array $allowed_values = null, $description = null,
                                $fraction_delimiter = null, $unit = null)
    {
        $this->archived = $archived;
        $this->data_type = $data_type;
        $this->doctor = $doctor;
        $this->id = $id;
        $this->is_fraction_field = $is_fraction_field;
        $this->allowed_values = $allowed_values;
        $this->description = $description;
        $this->fraction_delimiter = $fraction_delimiter;
        $this->unit = $unit;
    }

    public function jsonSerialize()
    {
        return [
            'archived' => $this->archived,
            'data_type' => $this->data_type,
            'doctor' => $this->doctor,
            'id' => $this->id,
            'is_fraction_field' => $this->is_fraction_field,
            'allowed_values' => $this->allowed_values,
            'description' => $this->description,
            'fraction_delimiter' => $this->fraction_delimiter,
            'unit' => $this->unit
        ];
    }

}