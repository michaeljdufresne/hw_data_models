<?php
/**
 * Created by IntelliJ IDEA.
 * User: marthahidalgo
 * Date: 4/22/19
 * Time: 1:51 PM
 */

namespace Edumedics\DataModels\Eloquent;


use Illuminate\Database\Eloquent\Model;

class FlaggedDuplicatePatients extends Model
{
    /**
     * @var string
     */
    protected $connection = 'pgsql_tenant';

    /**
     * @var string
     */
    protected $table = 'flagged_duplicate_patients';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function patient()
    {
        return $this->hasOne('Edumedics\DataModels\Aggregate\Patient', '_id', 'duplicate_patient_id');
    }

}