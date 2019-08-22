<?php

namespace Edumedics\DataModels\Aggregate;

use Edumedics\DataModels\Events\LabResultView\LabResultViewCreate;
use Edumedics\DataModels\Events\LabResultView\LabResultViewDelete;
use Edumedics\DataModels\Events\LabResultView\LabResultViewUpdate;
use Illuminate\Database\Eloquent\Model;

class LabResultView extends Model
{

    /**
     * @var string
     */
    protected $table = 'drchrono_lab_results_view';

    /**
     * @var string
     */
    protected $connection = 'pgsql_tenant';

    /**
     * @var string
     */
    protected $primaryKey = '_id';

    /**
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => LabResultViewCreate::class,
        'updated' => LabResultViewUpdate::class,
        'deleting' => LabResultViewDelete::class
    ];

    /**
     * @var array
     */
    protected $dates = ['result_date'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function drchrono_patient()
    {
        return $this->hasOne('Edumedics\DataModels\Aggregate\Patient', 'drchrono_patient_id', 'patient');
    }
}