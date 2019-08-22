<?php

namespace Edumedics\DataModels\DrChrono;

use Edumedics\DataModels\DrChrono\Appointments\AppointmentClinicalNote;
use Edumedics\DataModels\DrChrono\Appointments\CustomVital;
use Edumedics\DataModels\DrChrono\Appointments\Reminder;
use Edumedics\DataModels\DrChrono\Appointments\Vitals;
use Illuminate\Support\Facades\Log;

class Appointments extends BaseModel
{

    /**
     * @var integer
     */
    protected $doctor;

    /**
     * @var integer
     */
    protected $duration;

    /**
     * @var integer
     */
    protected $exam_room;

    /**
     * @var integer
     */
    protected $office;

    /**
     * @var integer
     */
    protected $patient;

    /**
     * @var \DateTime
     */
    protected $scheduled_time;

    /**
     * @var string
     */
    protected $color;

    /**
     * @var CustomVital[]
     */
    protected $custom_vitals;


    /**
     * @var string
     */
    protected $notes;

    /**
     * @var integer
     */
    protected $profile;

    /**
     * @var string
     */
    protected $reason;

    /**
     * @var integer
     */
    protected $reminder_profile;

    /**
     * @var string
     */
    protected $status;

    /**
     * @var Vitals
     */
    protected $vitals;

    /**
     * @var string
     */
    protected $billing_status;

    /**
     * @var AppointmentClinicalNote
     */
    protected $clinical_note;

    /**
     * @var string[]
     */
    protected $icd10_codes;

    /**
     * @var string[]
     */
    protected $icd9_codes;

    /**
     * @var string
     */
    protected $id;

    /**
     * @var Reminder[]
     */
    protected $reminders;

    /**
     * @var \DateTime
     */
    protected $created_at;

    /**
     * @var \DateTime
     */
    protected $updated_at;

    /**
     * @var \DateTime
     */
    protected $first_billed_date;

    /**
     * @var \DateTime
     */
    protected $last_billed_date;

    /**
     * @var boolean
     */
    protected $deleted_flag;

    /**
     * @var string
     */
    protected $primary_insurer_payer_id;

    /**
     * @var string
     */
    protected $primary_insurer_name;

    /**
     * @var string
     */
    protected $primary_insurance_id_number;

    /**
     * @var string
     */
    protected $secondary_insurer_payer_id;

    /**
     * @var string
     */
    protected $secondary_insurer_name;

    /**
     * @var string
     */
    protected $secondary_insurance_id_number;

    /**
     * @var boolean
     */
    protected $is_walk_in;

    /**
     * @var boolean
     */
    protected $allow_overlapping;

    /**
     * @var array
     */
    protected $rules = array(
        'doctor' => 'required|integer',
        'exam_room' => 'required|integer',
        'office' => 'required|integer',
        'patient' => 'required|integer',
        'scheduled_time' => 'required|date'
    );

    /**
     * Appointments constructor.
     * @param int $doctor
     * @param int $duration
     * @param int $exam_room
     * @param int $office
     * @param int $patient
     * @param \DateTime $scheduled_time
     * @param string $color
     * @param CustomVital[] $custom_vitals
     * @param string $notes
     * @param int $profile
     * @param string $reason
     * @param int $reminder_profile
     * @param string $status
     * @param Vitals $vitals
     */
    public function __construct($doctor = null, $duration = null, $exam_room = null, $office = null, $patient = null,
                                \DateTime $scheduled_time = null, $color = null, $custom_vitals = null, $notes = null,
                                $profile = null, $reason = null, $reminder_profile = null, $status = null, Vitals $vitals = null)
    {
        $this->doctor = $doctor;
        $this->duration = $duration;
        $this->exam_room = $exam_room;
        $this->office = $office;
        $this->patient = $patient;
        $this->scheduled_time = $scheduled_time;
        $this->color = $color;
        $this->custom_vitals = $custom_vitals;
        $this->notes = $notes;
        $this->profile = $profile;
        $this->reason = $reason;
        $this->reminder_profile = $reminder_profile;
        $this->status = $status;
        $this->vitals = $vitals;
    }

    protected function getSerializedCustomVitals()
    {
        if (!isset($this->custom_vitals) || empty($this->custom_vitals)) return null;

        $customVitals = [];
        foreach ($this->custom_vitals as $customVital)
        {
            if ($customVital instanceof CustomVital)
            {
                $customVitals[] = $customVital->jsonSerialize();
            }
        }

        return empty($customVitals) ? null : $customVitals;
    }

    /**
     * @param $icd10Codes
     * @return array
     */
    protected function normalizeICD10Codes($icd10Codes)
    {
        if (is_array($icd10Codes)) return $icd10Codes;
        if (is_string($icd10Codes))
        {
            $codesArray = explode(',', $icd10Codes);
            return array_filter(array_map('trim', $codesArray));
        }
        return [$icd10Codes];
    }

    public function jsonSerialize()
    {
        return [
            'doctor' => $this->doctor,
            'duration' => $this->duration,
            'exam_room' => $this->exam_room,
            'office' => $this->office,
            'patient' => $this->patient,
            'scheduled_time' => $this->formatDateTime($this->scheduled_time),
            'color' => $this->color,
            'custom_vitals' => $this->getSerializedCustomVitals(),
            'notes' => $this->notes,
            'profile' => $this->profile,
            'reason' => $this->reason,
            'reminder_profile' => $this->reminder_profile,
            'status' => $this->status,
            'vitals' => isset($this->vitals) ? $this->vitals->jsonSerialize() : null,
            'billing_status' => $this->billing_status,
            'clinical_note' => $this->clinical_note,
            'icd10_codes' => $this->normalizeICD10Codes($this->icd10_codes),
            'icd9_codes' => $this->icd9_codes,
            'id' => $this->id,
            'reminders' => $this->reminders,
            'created_at' => $this->formatDateTime($this->created_at),
            'updated_at' => $this->formatDateTime($this->updated_at),
            'first_billed_date' => $this->formatDateTime($this->first_billed_date),
            'last_billed_date' => $this->formatDateTime($this->last_billed_date),
            'deleted_flag' => $this->deleted_flag,
            'primary_insurer_payer_id' => $this->primary_insurer_payer_id,
            'primary_insurer_name' => $this->primary_insurer_name,
            'primary_insurance_id_number' => $this->primary_insurance_id_number,
            'secondary_insurer_payer_id' => $this->secondary_insurer_payer_id,
            'secondary_insurer_name' => $this->secondary_insurer_name,
            'secondary_insurance_id_number' => $this->secondary_insurance_id_number,
            'is_walk_in' => $this->is_walk_in,
            'allow_overlapping' => $this->allow_overlapping
        ];
    }

}