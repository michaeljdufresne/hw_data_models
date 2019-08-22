<?php


namespace Edumedics\DataModels\Dto\emVitals\Observation;


use Edumedics\DataModels\Dto\Dto;

/**
 * Class PerformerDto
 * @package Edumedics\DataModels\Dto\emVitals\Observation
 */
class PerformerDto extends Dto
{

    /**
     * @var string
     */
    public $reference;

    /**
     * @var string
     */
    public $display;

    /**
     * @var array
     */
    protected $fillable = [ 'reference', 'display' ];

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
            'reference' => $this->reference,
            'display' => $this->display
        ];
    }
}