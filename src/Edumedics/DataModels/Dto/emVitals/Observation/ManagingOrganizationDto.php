<?php


namespace Edumedics\DataModels\Dto\emVitals\Observation;

use Edumedics\DataModels\Dto\Dto;

/**
 * Class ManagingOrganizationDto
 * @package Edumedics\DataModels\Dto\emVitals\Observation
 */
class ManagingOrganizationDto extends Dto
{

    /**
     * @var string
     */
    public $name;

    /**
     * @var array
     */
    protected $fillable = [ 'name' ];

    /**
     * @param null $dataArray
     * @return mixed|void
     */
    public function populate($dataArray = null)
    {
        $this->fill($dataArray);
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'name' => $this->name
        ];
    }
}