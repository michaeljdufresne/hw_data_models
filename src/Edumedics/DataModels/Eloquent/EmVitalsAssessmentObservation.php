<?php


namespace Edumedics\DataModels\Eloquent;

use Edumedics\DataModels\Events\EmVitalsAssessmentObservation\EmVitalsAssessmentObservationCreate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class EmVitalsAssessmentObservation extends Model
{
    use Notifiable;

    /**
     * @var string
     */
    protected $connection = 'pgsql_tenant';

    /**
     * @var string
     */
    protected $table = 'emvitals_assessment_observation';

    /**
     * @var array
     */
    protected $dates = ['observation_received_at'];

    /**
     * @var array
     */
    protected $fillable = [
        'patient_id',
        'observation_task_id',
        'observation_document_id',
        'observation_received_at',
        'emv_phq8score', 'emv_gad7score', 'emv_pclc6score', 'emv_auditcscore',
        'emv_soduscore', 'emv_pss4score', 'emv_oslo3score', 'emv_sdoh4',
        'emv_sdoh5', 'emv_sdoh6', 'emv_phq3', 'emv_sf21', 'emv_cc1'
    ];

    /**
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => EmVitalsAssessmentObservationCreate::class
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function patient()
    {
        return $this->hasOne('Edumedics\DataModels\Aggregate\Patient', '_id', 'patient_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function task()
    {
        return $this->hasOne('Edumedics\DataModels\Eloquent\Tasks', 'id', 'observation_task_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function document()
    {
        return $this->hasOne('Edumedics\DataModels\Eloquent\Document', 'id', 'observation_document_id');
    }
}