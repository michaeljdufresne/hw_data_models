<?php

namespace Edumedics\DataModels\Eloquent;

use Edumedics\DataModels\Events\PatientDiagnoses\PatientDiagnosesCreate;
use Edumedics\DataModels\Events\PatientDiagnoses\PatientDiagnosesDelete;
use Edumedics\DataModels\Events\PatientDiagnoses\PatientDiagnosesUpdate;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PatientDiagnoses
 * @package Edumedics\DataModels\Eloquent
 */
class PatientDiagnoses extends Model
{

     /**
     * @var string
     */
    protected $connection = 'pgsql_tenant';
    /**
     * @var string
     */
    protected $table = 'patient_diagnoses';


    /**
<<<<<<< HEAD
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => PatientDiagnosesCreate::class,
        'updated' => PatientDiagnosesUpdate::class,
        'deleting' => PatientDiagnosesDelete::class
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function patient()
    {
        return $this->belongsTo('Edumedics\DataModels\Aggregate\Patient', 'patient_id', '_id');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function patientSnapShot()
    {
        return $this->belongsTo('Edumedics\DataModels\Aggregate\PatientSnapshot', 'patient_snapshot_id', '_id');
    }
}