<?php

namespace Edumedics\DataModels\StandardModels;


class RiskProfileUpdate extends StandardModel
{

    /**
     * @var array
     */
    protected $fillable = [ 'object_type', 'object_action', 'object_id', 'patient_id'];

    /**
     * @var array
     */
    public static $ObjectTypes = [
        'Appointment' => 1,
        'LabResultView' => 2,
        'EmVitalsAssessment' => 3
    ];

    /**
     * @var array
     */
    public static $ObjectActions = [
        'Create' => 1,
        'Update' => 2,
        'Delete' => 3
    ];

}