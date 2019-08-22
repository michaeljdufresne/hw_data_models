<?php


namespace Edumedics\DataModels\Aggregate;

use Edumedics\DataModels\Eloquent\EmVitalsAssessmentObservation;
use Edumedics\DataModels\Eloquent\ParticipantProgramEligibility;
use Edumedics\DataModels\Eloquent\ParticipantProgramEnrollment;
use Edumedics\DataModels\Eloquent\PatientCarePlans;
use Edumedics\DataModels\Events\PatientSnapshot\PatientSnapshotCreate;
use Edumedics\DataModels\Events\PatientSnapshot\PatientSnapshotDelete;
use Edumedics\DataModels\Events\PatientSnapshot\PatientSnapshotUpdate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PatientSnapshot extends Model
{

    use Notifiable;

    /**
     * @var string
     */
    protected $primaryKey = '_id';

    /**
     * @var string
     */
    protected $table = 'patient_snapshots';

    /**
     * @var string
     */
    protected $connection = 'pgsql_tenant';

    /**
     * @var array
     */
    public $appends = ['eligibilities', 'enrollments', 'careplans','most_recent_em_vitals_observation'];

    /**
     * @var array
     */
    protected $with = [
        'systolic', 'diastolic', 'waist', 'bmi', 'total_cholesterol', 'ldl', 'hdl',
        'a1c', 'triglycerides', 'glucose', 'glucose_fasting', 'glucose_non_fasting',
        'creatinine', 'bun', 'egfr', 'copd_stage', 'phq9_score', 'emv_phq8score',
        'emv_gad7score', 'emv_pclc6score', 'emv_auditcscore', 'emv_soduscore',
        'emv_pss4score', 'emv_oslo3score', 'emv_sdoh4', 'emv_sdoh5', 'emv_sdoh6',
        'emv_phq3', 'emv_sf21', 'emv_cc1'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'careplan_ids' => 'array',
        'eligibility_ids' => 'array',
        'enrollment_ids' => 'array'
    ];

    /**
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => PatientSnapshotCreate::class,
        'updated' => PatientSnapshotUpdate::class,
        'deleting' => PatientSnapshotDelete::class
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function patient()
    {
        return $this->belongsTo('Edumedics\DataModels\Aggregate\Patient', 'patient_id', '_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function patientDiagnoses()
    {
        return $this->hasMany('Edumedics\DataModels\Eloquent\PatientDiagnoses','patient_snapshot_id', '_id');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function mostRecentAppointment()
    {
        return $this->hasOne('Edumedics\DataModels\Aggregate\Appointment', '_id', 'most_recent_appointment');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function nextAppointment()
    {
        return $this->hasOne('Edumedics\DataModels\Aggregate\Appointment', '_id', 'next_appointment');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function systolic()
    {
        return $this->belongsTo('Edumedics\DataModels\Aggregate\PatientSnapshot\ClinicalValue', 'systolic_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function diastolic()
    {
        return $this->belongsTo('Edumedics\DataModels\Aggregate\PatientSnapshot\ClinicalValue', 'diastolic_id' , 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function waist()
    {
        return $this->belongsTo('Edumedics\DataModels\Aggregate\PatientSnapshot\ClinicalValue', 'waist_id' , 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bmi()
    {
        return $this->belongsTo('Edumedics\DataModels\Aggregate\PatientSnapshot\ClinicalValue', 'bmi_id' , 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function total_cholesterol()
    {
        return $this->belongsTo('Edumedics\DataModels\Aggregate\PatientSnapshot\ClinicalValue', 'total_cholesterol_id' , 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ldl()
    {
        return $this->belongsTo('Edumedics\DataModels\Aggregate\PatientSnapshot\ClinicalValue', 'ldl_id' , 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function hdl()
    {
        return $this->belongsTo('Edumedics\DataModels\Aggregate\PatientSnapshot\ClinicalValue', 'hdl_id' , 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function a1c()
    {
        return $this->belongsTo('Edumedics\DataModels\Aggregate\PatientSnapshot\ClinicalValue', 'a1c_id' , 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function glucose()
    {
        return $this->belongsTo('Edumedics\DataModels\Aggregate\PatientSnapshot\ClinicalValue', 'glucose_id' , 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function glucose_fasting()
    {
        return $this->belongsTo('Edumedics\DataModels\Aggregate\PatientSnapshot\ClinicalValue', 'glucose_fasting_id' , 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function glucose_non_fasting()
    {
        return $this->belongsTo('Edumedics\DataModels\Aggregate\PatientSnapshot\ClinicalValue', 'glucose_non_fasting_id' , 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function triglycerides()
    {
        return $this->belongsTo('Edumedics\DataModels\Aggregate\PatientSnapshot\ClinicalValue', 'triglycerides_id' , 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creatinine()
    {
        return $this->belongsTo('Edumedics\DataModels\Aggregate\PatientSnapshot\ClinicalValue', 'creatinine_id' , 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bun()
    {
        return $this->belongsTo('Edumedics\DataModels\Aggregate\PatientSnapshot\ClinicalValue', 'bun_id' , 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function egfr()
    {
        return $this->belongsTo('Edumedics\DataModels\Aggregate\PatientSnapshot\ClinicalValue', 'egfr_id' , 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function copd_stage()
    {
        return $this->belongsTo('Edumedics\DataModels\Aggregate\PatientSnapshot\ClinicalValue', 'copd_stage_id' , 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function phq9_score()
    {
        return $this->belongsTo('Edumedics\DataModels\Aggregate\PatientSnapshot\ClinicalValue', 'phq9_score_id' , 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function emv_phq8score()
    {
        return $this->belongsTo('Edumedics\DataModels\Aggregate\PatientSnapshot\ClinicalValue', 'emv_phq8score_id' , 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function emv_gad7score()
    {
        return $this->belongsTo('Edumedics\DataModels\Aggregate\PatientSnapshot\ClinicalValue', 'emv_gad7score_id' , 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function emv_pclc6score()
    {
        return $this->belongsTo('Edumedics\DataModels\Aggregate\PatientSnapshot\ClinicalValue', 'emv_pclc6score_id' , 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function emv_auditcscore()
    {
        return $this->belongsTo('Edumedics\DataModels\Aggregate\PatientSnapshot\ClinicalValue', 'emV_auditcscore_id' , 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function emv_soduscore()
    {
        return $this->belongsTo('Edumedics\DataModels\Aggregate\PatientSnapshot\ClinicalValue', 'emv_soduscore_id' , 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function emv_pss4score()
    {
        return $this->belongsTo('Edumedics\DataModels\Aggregate\PatientSnapshot\ClinicalValue', 'emv_pss4score_id' , 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function emv_oslo3score()
    {
        return $this->belongsTo('Edumedics\DataModels\Aggregate\PatientSnapshot\ClinicalValue', 'emv_oslo3score_id' , 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function emv_sdoh4()
    {
        return $this->belongsTo('Edumedics\DataModels\Aggregate\PatientSnapshot\ClinicalValue', 'emv_sdoh4_id' , 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function emv_sdoh5()
    {
        return $this->belongsTo('Edumedics\DataModels\Aggregate\PatientSnapshot\ClinicalValue', 'emv_sdoh5_id' , 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function emv_sdoh6()
    {
        return $this->belongsTo('Edumedics\DataModels\Aggregate\PatientSnapshot\ClinicalValue', 'emv_sdoh6_id' , 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function emv_phq3()
    {
        return $this->belongsTo('Edumedics\DataModels\Aggregate\PatientSnapshot\ClinicalValue', 'emv_phq3_id' , 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function emv_sf21()
    {
        return $this->belongsTo('Edumedics\DataModels\Aggregate\PatientSnapshot\ClinicalValue', 'emv_sf21_id' , 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function emv_cc1()
    {
        return $this->belongsTo('Edumedics\DataModels\Aggregate\PatientSnapshot\ClinicalValue', 'emv_cc1_id' , 'id');
    }

    /**
     * @return array
     */
    public function getEligibilitiesAttribute()
    {
        $eligibilities = [];
        if (isset($this->eligibility_ids))
        {
            foreach ($this->eligibility_ids as $eligibility_id)
            {
                $eligibilities[] = ParticipantProgramEligibility::find($eligibility_id);
            }
        }
        return $eligibilities;
    }

    /**
     * @return array
     */
    public function getEnrollmentsAttribute()
    {
        $enrollments = [];
        if (isset($this->enrollment_ids))
        {
            foreach ($this->enrollment_ids as $enrollment_id)
            {
                $enrollments[] = ParticipantProgramEnrollment::find($enrollment_id);
            }
        }
        return $enrollments;
    }

    /**
     * @return array
     */
    public function getCareplansAttribute()
    {
        $carePlans = [];
        if (isset($this->careplan_ids))
        {
            foreach ($this->careplan_ids as $careplan_id)
            {
                $carePlans[] = PatientCarePlans::with('clinical_care_plan')->with('care_plan_value_expiration')->find($careplan_id);
            }
        }
        return $carePlans;
    }

    /**
     * @return array
     */
    public function getMostRecentEmVitalsObservationAttribute()
    {
        $emVitalsObservation = EmVitalsAssessmentObservation::where('patient_id',$this->patient_id)->orderBy('observation_received_at','DESC')->first();
        return $emVitalsObservation;
    }

}