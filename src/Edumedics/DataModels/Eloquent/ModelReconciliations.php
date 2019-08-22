<?php

namespace Edumedics\DataModels\Eloquent;

use Edumedics\DataModels\Events\ModelReconciliations\ModelReconciliationsDelete;
use Edumedics\DataModels\Events\ModelReconciliations\ModelReconciliationsUpdate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ModelReconciliations extends Model {

    use Notifiable;

    const
        PATIENT_RECONCILIATION = 1,
        APPOINTMENT_RECONCILIATION = 2;

    /**
     * @var string
     */
    protected $connection = 'pgsql_tenant';

    /**
     * @var string
     */
    protected $table = 'model_reconciliations';
    /**
     * @var array
     */
    protected $guarded = array('id');

    /**
     * @var array
     */
    protected $dispatchesEvents = [
        'updated' => ModelReconciliationsUpdate::class,
        'deleting' => ModelReconciliationsDelete::class
    ];

}