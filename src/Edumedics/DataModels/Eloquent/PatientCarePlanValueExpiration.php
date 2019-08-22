<?php


namespace Edumedics\DataModels\Eloquent;


use Edumedics\DataModels\Events\PatientCarePlanValueExpiration\PatientCarePlanValueExpirationCreate;
use Edumedics\DataModels\Events\PatientCarePlanValueExpiration\PatientCarePlanValueExpirationDelete;
use Edumedics\DataModels\Events\PatientCarePlanValueExpiration\PatientCarePlanValueExpirationUpdate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PatientCarePlanValueExpiration extends Model
{

    use Notifiable;

    /**
     * @var string
     */
    protected $connection = 'pgsql_tenant';
    /**
     * @var string
     */
    protected $table = 'patient_care_plan_value_expiration';

    /**
     * @var array
     */
    protected $dates = [ 'value_expiration_date' ];

    /**
     * @var array
     */
    protected $with = [ 'patient_alert' ];

    /**
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => PatientCarePlanValueExpirationCreate::class,
        'updated' => PatientCarePlanValueExpirationUpdate::class,
        'deleting' => PatientCarePlanValueExpirationDelete::class
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function patient_care_plan()
    {
        return $this->belongsTo('Edumedics\DataModels\Eloquent\PatientCarePlans', 'patient_care_plan_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function drchrono_patient()
    {
        return $this->hasOne('Edumedics\DataModels\Aggregate\Patient', '_id', 'patient_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function patient_alert()
    {
        return $this->hasOne('Edumedics\DataModels\Eloquent\PatientAlerts', 'patient_care_plan_value_expiration_id', 'id');
    }

}