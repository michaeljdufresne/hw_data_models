<?php

namespace Edumedics\DataModels\Eloquent;

use Illuminate\Database\Eloquent\Model;

class PatientClient extends Model
{

    /**
     * @var string
     */
    protected $connection = 'pgsql_tenant';
    /**
     * @var string
     */
    protected $table = 'patients_clients';
    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @param $patientId
     * @param $clientId
     * @throws \Exception
     */
    public function activate($patientId, $clientId)
    {
        $this->patient_id = $patientId;
        $this->client_id = $clientId;
        $this->date_active = new \DateTime();
        $this->is_active = true;
        $this->save();
    }

    /**
     * @throws \Exception
     */
    public function expire()
    {
        $this->date_expired = new \DateTime();
        $this->is_active = false;
        $this->save();
    }

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
    public function client()
    {
        return $this->hasOne('Edumedics\DataModels\Eloquent\Client', 'id', 'client_id');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

}
