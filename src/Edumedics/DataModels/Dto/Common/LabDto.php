<?php
/**
 * Created by IntelliJ IDEA.
 * User: marthahidalgo
 * Date: 7/31/19
 * Time: 10:50 AM
 */

namespace Edumedics\DataModels\Dto\Common;


use Edumedics\DataModels\Dto\Common\Enums\UnitsOfMeasure;
use Edumedics\DataModels\Dto\Dto;

/**
 * Class LabDto
 * @package Edumedics\DataModels\Dto\Common
 * @OA\Schema( schema="LabDto" )
 */
class LabDto extends Dto
{
    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $lab_result_id;

    /**
     * @var ExternalIdDto[]
     * @OA\Property()
     */
    public $external_ids;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $order_id;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $document_id;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $patient_id;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $doctor_id;

    /**
     * @var \DateTime
     * @OA\Property()
     * "Y-m-d\TH:i:s"
     */
    public $specimen_received;

    /**
     * @var \DateTime
     * @OA\Property()
     * "Y-m-d\TH:i:s"
     */
    public $result_date;

    /**
     * @var string
     * also known as title
     * @OA\Property(format="string")
     */
    public $observation_description;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $order_status;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $result_status;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $value;

    /**
     * @var string
     * also known as abnormal_flag
     * @OA\Property(format="string")
     */
    public $abnormal_status;

    /**
     * @var string
     * also known as loinc_code
     * @OA\Property(format="string")
     */
    public $observation_code;

    /**
     * @var integer
     * @OA\Property(format="int64")
     */
    public $unit_of_measure;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $group_code;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $comments;

    /**
     * @var array
     */
    protected $fillable = ['lab_result_id','external_ids','order_id','document_id','patient_id','doctor_id',
        'specimen_received', 'result_date', 'observation_description','order_status','result_status',
        'result_date','value', 'abnormal_status','observation_code', 'unit_of_measure', 'group_code','comments'];

    /**
     * @param null $dataArray
     * @return mixed|void
     * @throws \Exception
     */
    public function populate($dataArray = null)
    {
        if (isset($dataArray) && is_array($dataArray)) {
            foreach ($dataArray as $k => $v) {
                switch ($k){
                    case '_id':
                        $this->lab_result_id = $v;
                        break;
                    case 'external_ids':
                        $this->{$k} = [];
                        foreach ($v as $externalId) {
                            $externalIdDto = new ExternalIdDto();
                            $externalIdDto->populate($externalId);
                            $this->{$k}[] = $externalIdDto;
                        }
                        break;
                    case 'drchrono_manual_lab_result_id':
                        if (!empty($v))
                        {
                            $externalIdDto = new ExternalIdDto();
                            $externalIdDto->fill([
                                'id' => $v,
                                'type' => ExternalIdDto::DrChronoId
                            ]);
                            $this->external_ids[] = $externalIdDto;
                        }
                        break;
                    case 'drchrono_lab_result_id':
                        if (!empty($v))
                        {
                            $externalIdDto = new ExternalIdDto();
                            $externalIdDto->fill([
                                'id' => $v,
                                'type' => ExternalIdDto::DrChronoId
                            ]);
                            $this->external_ids[] = $externalIdDto;
                        }
                        break;
                    case 'drchrono_lab_id':
                        $this->order_id = $v;
                        break;
                    case 'document':
                        $this->document_id = $v;
                        break;
                    case 'patient':
                        $this->patient_id = $v;
                        break;
                    case 'doctor':
                        $this->doctor_id = $v;
                        break;
                    case 'ordering_doctor':
                        $this->doctor_id = $v;
                        break;
                    case 'specimen_received':
                    case 'result_date':
                        $this->{$k} = new \DateTime($v);
                        break;
                    case 'results_released':
                        $this->result_date = new \DateTime($v);
                        break;
                    case 'test_performed':
                        $this->result_date = new \DateTime($v);
                        break;
                    case 'date_test_performed':
                        $this->result_date = new \DateTime($v);
                        break;
                    case 'status':
                        $this->order_status = $v;
                        break;
                    case 'lab_results':
                        foreach ($v as $column => $value){
                            switch ($column){
                                case 'status':
                                    $this->result_status = $value;
                                    break;
                                case 'unit':
                                    $this->unit_of_measure = UnitsOfMeasure::getUnitEnum($value);
                                    break;
                                default:
                                    $this->{$column} = $value;
                                    break;
                            }
                        }
                        break;
                    case 'lab_order_status':
                        $this->result_status = $v;
                        break;
                    case 'lab_result_value':
                        $this->value = $v;
                        break;
                    case 'loinc_code':
                        $this->observation_code = $v;
                        break;
                    case 'lab_result_value_units':
                        $this->unit_of_measure = UnitsOfMeasure::getUnitEnum($v);
                        break;
                    default:
                        $this->{$k} = $v;
                        break;
                }
            }
        }
    }


    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'lab_result_id' => $this->lab_result_id,
            'external_ids' => $this->jsonSerializeArray($this->external_ids),
            'patient_id' => $this->patient_id,
            'doctor_id' => $this->doctor_id,
            'specimen_received' => $this->formatDateTime($this->specimen_received),
            'result_date' => $this->formatDateTime($this->result_date),
            'observation_description' => $this->observation_description,
            'status' => $this->status,
            'value' => $this->value,
            'abnormal_status' => $this->abnormal_status,
            'observation_code' => $this->observation_code,
            'unit_of_measure' => $this->unit_of_measure,
            'group_code' => $this->group_code,
            'comments' => $this->comments
        ];
    }
}