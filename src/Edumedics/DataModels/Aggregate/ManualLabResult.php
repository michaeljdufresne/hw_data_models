<?php

namespace Edumedics\DataModels\Aggregate;

use Edumedics\DataModels\DrChrono\ManualLabResults;
use Edumedics\DataModels\Dto\Common\Enums\UnitsOfMeasure;
use Edumedics\DataModels\Dto\Common\ExternalIdDto;
use Edumedics\DataModels\Dto\Common\LabDto;
use Edumedics\DataModels\Events\ManualLabResult\ManualLabResultCreate;
use Edumedics\DataModels\Events\ManualLabResult\ManualLabResultDelete;
use Edumedics\DataModels\Events\ManualLabResult\ManualLabResultUpdate;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ManualLabResult
 * @package Edumedics\DataModels\Aggregate
 */
class ManualLabResult extends Model
{

    /**
     * @var string
     */
    protected $table = 'drchrono_manual_lab_results';

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
    protected $manualLabResultFields = [
        'id', 'date_test_performed', 'doctor_signoff', 'lab_abnormal_flag', 'lab_order_status', 'lab_result_value',
        'lab_result_value_as_float', 'lab_result_value_units', 'loinc_code', 'ordering_doctor', 'patient', 'scanned_in_result', 'title'
    ];

    /**
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => ManualLabResultCreate::class,
        'updated' => ManualLabResultUpdate::class,
        'deleting' => ManualLabResultDelete::class
    ];

    /**
     * @var array
     */
    protected $dates = ['date_test_performed'];

    /**
     * @param ManualLabResults $labResults
     */
    public function populate(ManualLabResults $labResults)
    {
        foreach ($this->manualLabResultFields as $k)
        {
            if (isset($labResults->{$k}))
            {
                switch ($k)
                {
                    case 'id':
                        $this->drchrono_manual_lab_result_id = (int)$labResults->{$k};
                        break;

                    default:
                        $this->{$k} = $labResults->{$k};
                }
            }
        }
        if (!isset($this->date_test_performed))
        {
            $this->date_test_performed = $labResults->created_at;
        }
    }

    public function populateFromDto(LabDto $emrLab){
        if (isset($emrLab) && is_array($emrLab)) {
            foreach ($emrLab as $k => $v) {
                switch ($k) {
                    case 'external_ids':
                        if (!empty($v)) {
                            foreach ($v as $externalId) {
                                switch ($externalId['type']) {
                                    case ExternalIdDto::DrChronoId:
                                        $this->drchrono_manual_lab_result_id = $externalId['id'];
                                        break;
                                }
                            }
                        }
                        break;
                    case 'lab_result_id':
                        $this->_id = $v;
                        break;
                    case 'patient_id':
                        $this->patient = $v;
                        break;
                    case 'doctor_id':
                        $this->ordering_doctor = $v;
                        break;
                    case 'result_date':
                        $this->date_test_performed = $v;
                        break;
                    case 'observation_description':
                        $this->title = $v;
                        break;
                    case 'result_status':
                        $this->lab_order_status = $v;
                        break;
                    case 'value':
                        $this->lab_result_value = $v;
                        break;
                    case 'abnormal_status':
                        $this->lab_abnormal_flag = $v;
                        break;
                    case 'observation_code':
                        $this->loinc_code = $v;
                        break;
                    case 'unit_of_measure':
                        $this->lab_result_value_units = UnitsOfMeasure::getUnitText($v);
                        break;
                    default:
                        $this->{$k} = $v;
                        break;
                }
            }
        }
    }
}