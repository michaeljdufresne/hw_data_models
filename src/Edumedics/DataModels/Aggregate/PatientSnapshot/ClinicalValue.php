<?php


namespace Edumedics\DataModels\Aggregate\PatientSnapshot;

use Illuminate\Database\Eloquent\Model;

class ClinicalValue extends Model
{

    /**
     * @var string
     */
    protected $table = 'patient_snapshot_clinical_value';

    /**
     * @var string
     */
    protected $connection = 'pgsql_tenant';

    /**
     * @var array
     */
    protected $fillable = [ 'value', 'origin', 'value_date' ];

    /**
     * @var array
     */
    protected $dates = [ 'value_date' ];

}