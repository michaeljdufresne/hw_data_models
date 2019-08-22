<?php


namespace Edumedics\DataModels\Dto\emVitals\Observation;


use Edumedics\DataModels\Dto\Dto;

/**
 * Class TelecomDto
 * @package Edumedics\DataModels\Dto\emVitals\Observation
 */
class TelecomDto extends Dto
{

    /**
     * @var string
     */
    public $system;

    /**
     * @var string
     */
    public $value;

    /**
     * @var string
     */
    public $rank;

    /**
     * @var array
     */
    protected $fillable = [ 'system', 'value', 'rank' ];

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
            'system' => $this->system,
            'value' => $this->value,
            'rank' => $this->rank
        ];
    }
}