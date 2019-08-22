<?php


namespace Edumedics\DataModels\DrChrono;

use Edumedics\DataModels\DrChrono\LabOrders\ICD10Code;

class LabOrders extends BaseModel
{

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var integer
     */
    protected $sublab;

    /**
     * @var integer
     */
    protected $doctor;

    /**
     * @var integer
     */
    protected $patient;

    /**
     * @var integer[]
     */
    protected $documents;

    /**
     * @var \DateTime
     */
    protected $timestamp;

    /**
     * @var string
     */
    protected $status;

    /**
     * @var ICD10Code[]
     */
    protected $icd10_codes;

    /**
     * @var string
     */
    protected $requisition_id;

    /**
     * @var string
     */
    protected $accession_number;

    /**
     * @var string
     */
    protected $notes;

    /**
     * @var array
     */
    protected $rules = array(
        'sublab' => 'required|integer',
        'doctor' => 'required|integer',
        'patient' => 'required|integer'
    );

    /**
     * LabOrders constructor.
     * @param int $id
     * @param int $sublab
     * @param int $doctor
     * @param int $patient
     * @param \integer[] $documents
     * @param \DateTime $timestamp
     * @param string $status
     * @param ICD10Code[] $icd10_codes
     * @param string $requisition_id
     * @param string $accession_number
     * @param string $notes
     */
    public function __construct($id = null, $sublab = null, $doctor = null, $patient = null, array $documents = null, \DateTime $timestamp = null,
                                $status = null, array $icd10_codes = null, $requisition_id = null, $accession_number = null, $notes = null)
    {
        $this->id = $id;
        $this->sublab = $sublab;
        $this->doctor = $doctor;
        $this->patient = $patient;
        $this->documents = $documents;
        $this->timestamp = $timestamp;
        $this->status = $status;
        $this->icd10_codes = $icd10_codes;
        $this->requisition_id = $requisition_id;
        $this->accession_number = $accession_number;
        $this->notes = $notes;
    }

    protected function getSerializedICD10Codes()
    {
        if (!isset($this->icd10_codes) || empty($this->icd10_codes)) return null;

        $icd10Codes = [];
        foreach ($this->icd10_codes as $icd10Code)
        {
            if ($icd10Code instanceof ICD10Code)
            {
                $icd10Codes[] = $icd10Code->jsonSerialize();
            }
        }

        return empty($icd10Codes) ? null : $icd10Codes;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'sublab' => $this->sublab,
            'doctor' => $this->doctor,
            'patient' => $this->patient,
            'documents' => $this->documents,
            'timestamp' => $this->formatDateTime($this->timestamp),
            'status' => $this->status,
            'icd10_codes' => $this->getSerializedICD10Codes(),
            'requisition_id' => $this->requisition_id,
            'accession_number' => $this->accession_number,
            'notes' => $this->notes
        ];
    }

}