<?php


namespace Edumedics\DataModels\Eloquent\Reporting;


use Illuminate\Database\Eloquent\Model;

class ChronicDiseaseCotValues extends Model
{
    protected $connection = 'pgsql_reporting';

    protected $table = 'cc_cot_values';

    protected $fillable = [ 'patient_id', 'client_id', 'program_enrollment_type', 'enrollment_date',
        'value_type', 'result_value', 'result_value_origin', 'result_value_date', 'time_since_enrollment' ];

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