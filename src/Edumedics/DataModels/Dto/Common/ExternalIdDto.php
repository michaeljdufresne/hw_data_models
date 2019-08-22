<?php


namespace Edumedics\DataModels\Dto\Common;


use Edumedics\DataModels\Dto\Dto;

/**
 * Class ExternalIdDto
 * @package Edumedics\DataModels\Dto\Common
 * @OA\Schema( schema="ExternalIdDto" )
 */
class ExternalIdDto extends Dto
{

    const
        DrChronoId                  = 1,
        NavMdId                     = 2,
        ViiMedPersonId              = 3,
        ViiMedUserId                = 4,
        EmVitalsBcid                = 5,
        EClinicalWorksId            = 6;


    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $id;

    /**
     * @var integer
     * @OA\Property(format="int64")
     */
    public $type;

    /**
     * @var array
     */
    protected $fillable = [
        'id', 'type'
    ];

    /**
     * @var array
     */
    public static $EHR_TYPES = [
        ExternalIdDto::DrChronoId,
        ExternalIdDto::EClinicalWorksId
    ];

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
            'id' => $this->id,
            'type' => $this->type
        ];
    }

}