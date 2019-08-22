<?php

namespace Edumedics\DataModels\DrChrono;


class LineItems extends BaseModel
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $appointment;

    /**
     * @var integer
     */
    protected $patient;

    /**
     * @var integer
     */
    protected $doctor;

    /**
     * @var string
     */
    protected $billing_status;

    /**
     * @var boolean
     */
    protected $denied_flag;

    /**
     * @var string
     */
    protected $code;

    /**
     * @var string
     */
    protected $procedure_type;

    /**
     * @var string
     */
    protected $quantity;

    /**
     * @var string
     */
    protected $units;

    /**
     * @var array
     */
    protected $modifiers;

    /**
     * @var array
     */
    protected $diagnosis_pointers;

    /**
     * @var \DateTime
     */
    protected $updated_at;

    /**
     * @var string
     */
    protected $price;

    /**
     * @var string
     */
    protected $billed;

    /**
     * @var string
     */
    protected $allowed;

    /**
     * @var string
     */
    protected $adjustment;

    /**
     * @var string
     */
    protected $ins1_paid;

    /**
     * @var string
     */
    protected $ins2_paid;

    /**
     * @var string
     */
    protected $ins3_paid;

    /**
     * @var string
     */
    protected $ins_total;

    /**
     * @var string
     */
    protected $pt_paid;

    /**
     * @var string
     */
    protected $paid_total;

    /**
     * @var string
     */
    protected $balance_ins;

    /**
     * @var string
     */
    protected $balance_pt;

    /**
     * @var string
     */
    protected $balance_total;

    /**
     * @var \DateTime
     */
    protected $service_date;

    /**
     * @var \DateTime
     */
    protected $posted_date;

    /**
     * @var string
     */
    protected $expected_reimbursement;

    /**
     * LineItems constructor.
     * @param int $id
     * @param string $appointment
     * @param int $patient
     * @param int $doctor
     * @param string $billing_status
     * @param bool $denied_flag
     * @param string $code
     * @param string $procedure_type
     * @param string $quantity
     * @param string $units
     * @param array $modifiers
     * @param array $diagnosis_pointers
     * @param \DateTime $updated_at
     * @param string $price
     * @param string $billed
     * @param string $allowed
     * @param string $adjustment
     * @param string $ins1_paid
     * @param string $ins2_paid
     * @param string $ins3_paid
     * @param string $ins_total
     * @param string $pt_paid
     * @param string $paid_total
     * @param string $balance_ins
     * @param string $balance_pt
     * @param string $balance_total
     * @param \DateTime $service_date
     * @param \DateTime $posted_date
     * @param string $expected_reimbursement
     */
    public function __construct($id, $appointment, $patient, $doctor, $billing_status,
                                $denied_flag, $code, $procedure_type,
                                $quantity, $units, array $modifiers, array $diagnosis_pointers,
                                \DateTime $updated_at, $price, $billed, $allowed, $adjustment,
                                $ins1_paid, $ins2_paid, $ins3_paid, $ins_total, $pt_paid,
                                $paid_total, $balance_ins, $balance_pt, $balance_total, \DateTime $service_date,
                                \DateTime $posted_date, $expected_reimbursement)
    {
        $this->id = $id;
        $this->appointment = $appointment;
        $this->patient = $patient;
        $this->doctor = $doctor;
        $this->billing_status = $billing_status;
        $this->denied_flag = $denied_flag;
        $this->code = $code;
        $this->procedure_type = $procedure_type;
        $this->quantity = $quantity;
        $this->units = $units;
        $this->modifiers = $modifiers;
        $this->diagnosis_pointers = $diagnosis_pointers;
        $this->updated_at = $updated_at;
        $this->price = $price;
        $this->billed = $billed;
        $this->allowed = $allowed;
        $this->adjustment = $adjustment;
        $this->ins1_paid = $ins1_paid;
        $this->ins2_paid = $ins2_paid;
        $this->ins3_paid = $ins3_paid;
        $this->ins_total = $ins_total;
        $this->pt_paid = $pt_paid;
        $this->paid_total = $paid_total;
        $this->balance_ins = $balance_ins;
        $this->balance_pt = $balance_pt;
        $this->balance_total = $balance_total;
        $this->service_date = $service_date;
        $this->posted_date = $posted_date;
        $this->expected_reimbursement = $expected_reimbursement;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'appointment' => $this->appointment,
            'patient' => $this->patient,
            'doctor' => $this->doctor,
            'billing_status' => $this->billing_status,
            'denied_flag' => $this->denied_flag,
            'code' => $this->code,
            'procedure_type' => $this->procedure_type,
            'quantity' => $this->quantity,
            'units' => $this->units,
            'modifiers' => $this->modifiers,
            'diagnosis_pointers' => $this->diagnosis_pointers,
            'updated_at' => $this->formatDateTime($this->updated_at),
            'price' => $this->price,
            'billed' => $this->billed,
            'allowed' => $this->allowed,
            'adjustment' => $this->adjustment,
            'ins1_paid' => $this->ins1_paid,
            'ins2_paid' => $this->ins2_paid,
            'ins3_paid' => $this->ins3_paid,
            'ins_total' => $this->ins_total,
            'pt_paid' => $this->pt_paid,
            'paid_total' => $this->paid_total,
            'balance_ins' => $this->balance_ins,
            'balance_pt' => $this->balance_pt,
            'balance_total' => $this->balance_total,
            'service_date' => $this->formatDate($this->service_date),
            'posted_date' => $this->formatDate($this->posted_date),
            'expected_reimbursement' => $this->expected_reimbursement
        ];
    }


}