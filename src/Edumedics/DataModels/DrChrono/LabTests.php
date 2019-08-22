<?php

namespace Edumedics\DataModels\DrChrono;


class LabTests extends BaseModel
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
    protected $name;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var \DateTime
     */
    protected $collection_date;

    /**
     * @var string
     */
    protected $internal_notes;

    /**
     * @var string
     */
    protected $report_notes;

    /**
     * @var string
     */
    protected $status;

    /**
     * @var string
     */
    protected $specimen_source;

    /**
     * @var string
     */
    protected $specimen_condition;

    /**
     * @var float
     */
    protected $specimen_total_volume;

    /**
     * @var array
     */
    protected $rules = array(
        'lab_order' => 'requried|integer'
    );

    /**
     * LabTests constructor.
     * @param int $id
     * @param int $lab_order
     * @param string $name
     * @param string $description
     * @param \DateTime $collection_date
     * @param string $internal_notes
     * @param string $report_notes
     * @param string $status
     * @param string $specimen_source
     * @param string $specimen_condition
     * @param float $specimen_total_volume
     */
    public function __construct(int $id = null, int $lab_order = null, string $name = null, string $description = null,
                                \DateTime $collection_date = null, string $internal_notes = null, string $report_notes = null,
                                string $status = null, string $specimen_source = null, string $specimen_condition = null,
                                float $specimen_total_volume = null)
    {
        $this->id = $id;
        $this->lab_order = $lab_order;
        $this->name = $name;
        $this->description = $description;
        $this->collection_date = $collection_date;
        $this->internal_notes = $internal_notes;
        $this->report_notes = $report_notes;
        $this->status = $status;
        $this->specimen_source = $specimen_source;
        $this->specimen_condition = $specimen_condition;
        $this->specimen_total_volume = $specimen_total_volume;
    }


    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'lab_order' => $this->lab_order,
            'name' => $this->name,
            'description' => $this->description,
            'collection_date' => $this->formatDateTime($this->collection_date),
            'internal_notes' => $this->internal_notes,
            'report_notes' => $this->report_notes,
            'status' => $this->status,
            'specimen_source' => $this->specimen_source,
            'specimen_condition' => $this->specimen_condition,
            'specimen_total_volume' => $this->specimen_total_volume
        ];
    }

}