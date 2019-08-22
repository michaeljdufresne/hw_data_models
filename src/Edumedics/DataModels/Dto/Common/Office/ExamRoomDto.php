<?php

namespace Edumedics\DataModels\Dto\Common\Office;


use Edumedics\DataModels\Dto\Dto;

/**
 * Class ExamRoomDto
 * @package Edumedics\DataModels\Dto\Common\Office
 * @OA\Schema( schema="ExamRoomDto" )
 */
class ExamRoomDto extends Dto
{
    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $exam_room_id;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $room_number;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $name;

    /**
     * @var array
     */
    protected $fillable = ["exam_room_id", "room_number", "name"];

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
                    case 'id':
                        $this->exam_room_id = $v;
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
            "exam_room_id" => $this->exam_room_id,
            "room_number" => $this->room_number,
            "name" => $this->name
        ];
    }
}