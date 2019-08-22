<?php


namespace Edumedics\DataModels\Dto\emVitals\Observation;


use Edumedics\DataModels\Dto\Dto;

/**
 * Class DateAbsentReasonDto
 * @package Edumedics\DataModels\Dto\emVitals\Observation
 */
class DateAbsentReasonDto extends Dto
{

    /**
     * @var CodingDto[]
     */
    public $coding;

    /**
     * @var string
     */
    public $text;

    /**
     * @var array
     */
    protected $fillable = ['coding', 'text'];

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
                if ($k == 'coding')
                {
                    $this->{$k} = [];
                    foreach ($v as $coding) {
                        $codingDto = new CodingDto();
                        $codingDto->populate($coding);
                        $this->{$k}[] = $codingDto;
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
            'text' => $this->text,
            'coding' => $this->jsonSerializeArray($this->coding)
        ];
    }
}