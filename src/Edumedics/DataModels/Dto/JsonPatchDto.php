<?php


namespace Edumedics\DataModels\Dto;


/**
 * Class JsonPatchDto
 * @package Edumedics\DataModels\Dto
 * @OA\Schema( schema="JsonPatchDto" )
 */
class JsonPatchDto extends Dto
{

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $op;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $path;

    /**
     * @var mixed
     * @OA\Property()
     */
    public $value;

    /**
     * @var array
     */
    protected $fillable = [
        'op', 'path', 'value'
    ];

    /**
     * JsonPatchDto constructor.
     * @param string $op
     * @param string $path
     * @param string $value
     */
    public function __construct(string $op, string $path, string $value)
    {
        $this->op = $op;
        $this->path = $path;
        $this->value = $value;
    }

    /**
     * @param null $dataArray
     * @return mixed|void
     */
    public function populate($dataArray = null) {}

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            "op" => $this->op,
            "path" => $this->path,
            "value" => $this->getSerializedValue()
        ];
    }

    /**
     * @return array|mixed|string|null
     */
    protected function getSerializedValue()
    {
        if ($this->value instanceof \DateTime)
        {
            return $this->formatDateTime($this->value);
        }
        elseif (is_array($this->value))
        {
            return $this->jsonSerializeArray($this->value);
        }
        elseif (is_object($this->value))
        {
            return $this->jsonSerializeObject($this->value);
        }
        return $this->value;
    }
}