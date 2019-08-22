<?php


namespace Edumedics\DataModels\Dto\emVitals\Observation;


use Edumedics\DataModels\Dto\Dto;

/**
 * Class ValueAttachmentDto
 * @package Edumedics\DataModels\Dto\emVitals\Observation
 */
class ValueAttachmentDto extends Dto
{

    /**
     * @var string
     */
    public $contentType;

    /**
     * @var string
     */
    public $language;

    /**
     * @var string
     */
    public $data;

    /**
     * @var string
     */
    public $title;

    /**
     * @var \DateTime
     */
    public $creation;

    /**
     * @var array
     */
    protected $fillable = [ 'contentType', 'language', 'data', 'title', 'creation' ];

    /**
     * @param null $dataArray
     * @return mixed|void
     * @throws \Exception
     */
    public function populate($dataArray = null)
    {
        if (isset($dataArray) && is_array($dataArray))
        {
            foreach ($dataArray as $k => $v)
            {
                if ($k == 'creation')
                {
                    $this->{$k} = new \DateTime($v);
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
            'contentType' => $this->contentType,
            'language' => $this->language,
            'data' => $this->data,
            'title' => $this->title,
            'creation' => $this->formatDateTime($this->creation)
        ];
    }
}