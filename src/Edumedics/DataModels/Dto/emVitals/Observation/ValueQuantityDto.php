<?php


namespace Edumedics\DataModels\Dto\emVitals\Observation;


use Edumedics\DataModels\Dto\Dto;

/**
 * Class ValueQuantityDto
 * @package Edumedics\DataModels\Dto\emVitals\Observation
 */
class ValueQuantityDto extends Dto
{

    /**
     * @var double
     */
    public $value;

    /**
     * @var array
     */
    protected $fillable = [ 'value' ];

    /**
     * @param null $dataArray
     * @return mixed|void
     */
    public function populate($dataArray = null)
    {
        if (isset($dataArray) && is_array($dataArray))
        {
            $this->fill($dataArray);
        }
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'value' => $this->value
        ];
    }
}