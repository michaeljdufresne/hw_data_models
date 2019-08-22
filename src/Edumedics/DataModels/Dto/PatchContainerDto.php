<?php


namespace Edumedics\DataModels\Dto;


/**
 * Class PatchContainerDto
 * @package Edumedics\DataModels\Dto
 * @OA\Schema( schema="PatchContainerDto" )
 */
class PatchContainerDto extends Dto
{

    /**
     * @var JsonPatchDto[]
     * @OA\Property()
     */
    public $patches;


    /**
     * PatchContainerDto constructor.
     * @param Dto $dto
     */
    public function __construct(Dto $dto)
    {
        foreach ($dto as $k => $v)
        {
            if ($k == 'fillable') continue;
            if (isset($v) && !is_null($v))
            {
                $this->patches[] = new JsonPatchDto('add', $k, $v);
            }
        }
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
        return $this->patches;
    }

}