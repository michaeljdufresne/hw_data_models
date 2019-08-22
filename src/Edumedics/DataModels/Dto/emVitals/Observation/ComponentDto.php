<?php


namespace Edumedics\DataModels\Dto\emVitals\Observation;


use Edumedics\DataModels\Dto\Dto;

/**
 * Class ComponentDto
 * @package Edumedics\DataModels\Dto\emVitals\Observation
 */
class ComponentDto extends Dto
{

    /**
     * @var CodeDto
     */
    public $code;

    /**
     * @var ValueCodeableConceptDto
     */
    public $valueCodeableConcept;

    /**
     * @var ValueQuantityDto
     */
    public $valueQuantity;

    /**
     * @var DateAbsentReasonDto
     */
    public $dateAbsentReason;

    /**
     * @var string
     */
    public $valueString;

    /**
     * @var array
     */
    protected $fillable = [ 'code', 'valueCodeableConcept', 'valueQuantity', 'dateAbsentReason', 'valueString' ];

    /**
     * @param null $dataArray
     * @return mixed|void
     */
    public function populate($dataArray = null)
    {
        if (isset($dataArray) && is_array($dataArray))
        {
            foreach ($dataArray as $k => $v)
            {
                switch ($k)
                {
                    case 'code':
                        $codeDto = new CodeDto();
                        $codeDto->populate($v);
                        $this->{$k} = $codeDto;
                        break;

                    case 'valueCodeableConcept':
                        $valueCodeableConceptDto = new ValueCodeableConceptDto();
                        $valueCodeableConceptDto->populate($v);
                        $this->{$k} = $valueCodeableConceptDto;
                        break;

                    case 'valueQuantity':
                        $valueQuantityDto = new ValueQuantityDto();
                        $valueQuantityDto->populate($v);
                        $this->{$k} = $valueQuantityDto;
                        break;

                    case 'dateAbsentReason':
                        $dateAbsentReasonDto = new DateAbsentReasonDto();
                        $dateAbsentReasonDto->populate($v);
                        $this->{$k} = $dateAbsentReasonDto;
                        break;

                    case 'valueString':
                        $this->{$k} = $v;

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
            'code' => $this->jsonSerializeObject($this->code),
            'valueCodeableConcept' => $this->jsonSerializeObject($this->valueCodeableConcept),
            'valueQuantity' => $this->jsonSerializeObject($this->valueQuantity),
            'dateAbsentReason' => $this->jsonSerializeObject($this->dateAbsentReason),
            'valueString' => $this->valueString
        ];
    }
}