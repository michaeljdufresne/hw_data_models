<?php


namespace Edumedics\DataModels\Eloquent;


use Edumedics\DataModels\Events\PatientCarePlans\PatientCarePlanCreate;
use Edumedics\DataModels\Events\PatientCarePlans\PatientCarePlanDelete;
use Edumedics\DataModels\Events\PatientCarePlans\PatientCarePlanUpdate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PatientCarePlans extends Model
{
    use Notifiable;

    /**
     * @var string
     */
    protected $connection = 'pgsql_tenant';
    /**
     * @var string
     */
    protected $table = 'patient_care_plans';

    /**
     * @var array
     */
    protected $fillable = [ 'patient_id', 'care_plan_id' ];
    /**
     * @var array
     */
    protected $dates = [ 'active_date', 'expiration_date' ];

    /**
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => PatientCarePlanCreate::class,
        'updated' => PatientCarePlanUpdate::class,
        'deleting' => PatientCarePlanDelete::class
    ];

    /**
     * @param $query
     * @param null $patientId
     * @return mixed
     */
    public function scopeActive($query, $patientId = null)
    {
        if (!is_null($patientId))
        {
            return $query->where(['is_active' => true, 'patient_id' => $patientId]);
        }
        return $query->where('is_active', true);
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
    public function clinical_care_plan()
    {
        return $this->hasOne('Edumedics\DataModels\Eloquent\ClinicalCarePlans', 'id', 'care_plan_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function care_plan_value_expiration()
    {
        return $this->hasOne('Edumedics\DataModels\Eloquent\PatientCarePlanValueExpiration', 'patient_care_plan_id', 'id');
    }

    /**
     *
     */
    public function activate()
    {
        $this->is_active = true;
        $this->active_date = new \DateTime();
        $this->save();
    }

    /**
     *
     */
    public function expire()
    {
        $this->is_active = false;
        $this->expiration_date = new \DateTime();
        $this->save();
    }
}