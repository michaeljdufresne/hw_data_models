<?php


namespace Edumedics\DataModels\Eloquent\Reporting;


use Illuminate\Database\Eloquent\Model;

class ChronicDiseaseValueAggregates extends Model
{

    protected $connection = 'pgsql_reporting';

    protected $table = 'st_in_value_aggregates';

    protected $fillable = [ 'patient_id', 'client_id', 'value_type',
        'initial_value', 'initial_value_origin', 'initial_value_threshold',
        'most_recent_value', 'most_recent_value_origin', 'most_recent_value_threshold' ];

    public static $valueTypes = [
        'SystolicBloodPressure' => 1,
        'DiastolicBloodPressure' => 2,
        'BMI' => 3,
        'Triglycerides' => 4,
        'LDL' => 5,
        'TC/HDL' => 6,
        'HbA1c' => 7
    ];

}