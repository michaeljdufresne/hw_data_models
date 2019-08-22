<?php


namespace Edumedics\DataModels\Dto\emVitals\Observation;


use Edumedics\DataModels\Dto\Dto;

/**
 * Class CodeDto
 * @package Edumedics\DataModels\Dto\emVitals\Observation
 */
class CodeDto extends Dto
{

    /**
     * @var CodingDto[]
     */
    public $coding;

    /**
     * @var array
     */
    protected $fillable = ['coding'];

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
                $this->{$k} = [];
                foreach ($v as $coding) {
                    $codingDto = new CodingDto();
                    $codingDto->populate($coding);
                    $this->{$k}[] = $codingDto;
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
            'coding' => $this->jsonSerializeArray($this->coding)
        ];
    }
}