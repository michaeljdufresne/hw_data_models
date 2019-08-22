<?php
/**
 * Created by IntelliJ IDEA.
 * User: marthahidalgo
 * Date: 7/29/19
 * Time: 11:24 AM
 */

namespace Edumedics\DataModels\Dto\Common\Appointment;


use Edumedics\DataModels\Dto\Dto;

/**
 * Class VitalsDto
 * @package Edumedics\DataModels\Dto\Common\Appointment
 * @OA\Schema( schema="VitalsDto" )
 */
class VitalsDto extends Dto
{

    /**
     * @var integer
     * @OA\Property(format="int64")
     */
    public $vital_type;
    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $value;
    /**
     * @var integer
     * @OA\Property(format="int64")
     */
    public $unit_of_measure;

    /**
     * @var array
     */
    protected $fillable = ['vital_type', 'value', 'unit_of_measure'];

    /**
     * @param null $dataArray
     * @return mixed|void
     */
    public function populate($dataArray = null)
    {
        if (isset($dataArray) && is_array($dataArray)) {
            foreach ($dataArray as $k => $v) {
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
            'vital_type' => $this->vital_type,
            'value' => $this->value,
            'unit_of_measure' => $this->unit_of_measure
        ];
    }
}

