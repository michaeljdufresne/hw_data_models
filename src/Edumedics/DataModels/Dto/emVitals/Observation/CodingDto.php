<?php


namespace Edumedics\DataModels\Dto\emVitals\Observation;


use Edumedics\DataModels\Dto\Dto;

/**
 * Class CodingDto
 * @package Edumedics\DataModels\Dto\emVitals\Observation
 */
class CodingDto extends Dto
{

    /**
     * @var string
     */
    public $system;

    /**
     * @var string
     */
    public $version;

    /**
     * @var string
     */
    public $code;

    /**
     * @var string
     */
    public $display;

    /**
     * @var boolean
     */
    public $userSelected;

    /**
     * @var array
     */
    protected $fillable = [ 'system', 'version', 'code', 'display', 'userSelected' ];

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
                $this->{$k} = $v;
            }
        }
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'system' => $this->system,
            'version' => $this->version,
            'code' => $this->code,
            'display' => $this->display,
            'userSelected' => $this->userSelected
        ];
    }
}