<?php


namespace Edumedics\DataModels\Eloquent;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PatientIdMap extends Model
{

    use Notifiable;

    /**
     * @var string
     */
    protected $connection = 'pgsql';

    /**
     * @var string
     */
    protected $table = 'patient_id_map';

    /**
     * @var array
     */
    protected $fillable = [
        'healthward_patient_uuid', 'drchrono_patient_id', 'navmd_id', 'env_config',
        'viimed_person_id', 'viimed_user_id', 'viimed_org_id', 'emvitals_bcid'
    ];

}