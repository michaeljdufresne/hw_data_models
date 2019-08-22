<?php

namespace Edumedics\DataModels\Eloquent;

use Illuminate\Database\Eloquent\Model;

class ImportHistoryDetails extends Model {


    /**
     * @var array
     */
    public static $actions = [
        1 => 'Patient Added',
        2 => 'Eligibility Added',
        3 => 'Eligibility Removed',
        4 => 'Enrollment Removed',
        5 => 'Patient Updated'
    ];

    protected $casts = ['previous_patient_object' => 'array'];
    /**
     * @var string
     */
    protected $connection = 'pgsql_tenant';

    /**
     * @var string
     */
    protected $table = 'import_history_details';

    /**
     * @var array
     */
    protected $fillable = ['history_id', 'action', 'participant_id', 'participant_eligiblity_id', 'previous_patient_object'];




}