<?php


namespace Edumedics\DataModels\Dto\emVitals\Observation;


use Edumedics\DataModels\Dto\Dto;

/**
 * Class IdentifierDto
 * @package Edumedics\DataModels\Dto\emVitals\Observation
 */
class IdentifierDto extends Dto
{

    /**
     * @var string
     */
    public $use;

    /**
     * @var TypeDto
     */
    public $type;

    /**
     * @var string
     */
    public $system;

    /**
     * @var string
     */
    public $value;

    /**
     * @var AssignerDto
     */
    public $assigner;

    /**
     * @var array
     */
    protected $fillable = [ 'use', 'type', 'system', 'value', 'assigner' ];

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
                    case 'type':
                        $typeDto = new TypeDto();
                        $typeDto->populate($v);
                        $this->{$k} = $typeDto;
                        break;

                    case 'assigner':
                        $assignerDto = new AssignerDto();
                        $assignerDto->populate($v);
                        $this->{$k} = $assignerDto;
                        break;

                    default:
                        $this->{$k} = $v;
                        break;

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
            'type' => $this->jsonSerializeObject($this->type),
            'system' => $this->system,
            'value' => $this->value,
            'assigner' => $this->jsonSerializeObject($this->assigner)
        ];
    }

}