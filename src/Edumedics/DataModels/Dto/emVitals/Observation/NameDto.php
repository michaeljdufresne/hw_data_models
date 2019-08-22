<?php


namespace Edumedics\DataModels\Dto\emVitals\Observation;


use Edumedics\DataModels\Dto\Dto;

/**
 * Class NameDto
 * @package Edumedics\DataModels\Dto\emVitals\Observation
 */
class NameDto extends Dto
{

    /**
     * @var string
     */
    public $use;

    /**
     * @var string
     */
    public $text;

    /**
     * @var string
     */
    public $family;

    /**
     * @var string[]
     */
    public $given;

    /**
     * @var array
     */
    protected $fillable = [ 'use', 'text', 'family', 'given' ];

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
                if ($k == 'given')
                {
                    $this->{$k} = [];
                    foreach ($v as $given) {
                        $this->{$k}[] = $given;
                    }
                }
                else
                {
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
            'use' => $this->use,
            'text' => $this->text,
            'family' => $this->family,
            'given' => $this->given
        ];
    }
}