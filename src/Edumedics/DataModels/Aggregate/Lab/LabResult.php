<?php

namespace Edumedics\DataModels\Aggregate\Lab;

use Edumedics\DataModels\DrChrono\LabResults;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LabResult
 * @package Edumedics\DataModels\Aggregate\Lab
 */
class LabResult extends Model
{

    /**
     * @var string
     */
    protected $table = 'drchrono_lab_results';

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
    protected $dates = ['specimen_received', 'results_released'];

    /**
     * @var array
     */
    protected $labResultFields = [
        'id', 'lab_order', 'document', 'lab_test', 'specimen_received', 'results_released', 'status', 'value',
        'abnormal_status', 'is_abnormal', 'normal_range', 'observation_code', 'observation_description',
        'group_code', 'unit', 'value_is_numeric', 'comments'
    ];

    /**
     * @param LabResults $labResult
     */
    public function populate(LabResults $labResult)
    {
        foreach ($this->labResultFields as $k)
        {
            if (isset($labResult->{$k}))
            {
                switch ($k)
                {
                    case 'id':
                        $this->drchrono_lab_result_id = (int)$labResult->{$k};
                        break;

                    default:
                        $this->{$k} = $labResult->{$k};
                }
            }
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lab()
    {
        return $this->belongsTo('Edumedics\DataModels\Aggregate\Lab', 'lab_order', 'drchrono_lab_id');
    }

}