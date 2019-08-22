<?php
/**
 * Created by IntelliJ IDEA.
 * User: marthahidalgo
 * Date: 8/1/19
 * Time: 10:50 AM
 */

namespace Edumedics\DataModels\Dto\Common;


use Edumedics\DataModels\Dto\Dto;

/**
 * Class BiometricAppointmentDto
 * @package Edumedics\DataModels\Dto\Common
 * @OA\Schema( schema="BiometricAppointmentDto" )
 */
class BiometricAppointmentDto extends Dto
{
    /**
     * @var AppointmentDto
     * @OA\Property()
     */
    public $appointment;
    /**
     * @var LabDto[]
     * @OA\Property()
     */
    public $lab_results;

    /**
     * @var array
     */
    protected $fillable = ['appointment','lab_results'];

    /**
     * @param null $dataArray
     * @return mixed|void
     * @throws \Exception
     */
    public function populate($dataArray = null)
    {
        if (isset($dataArray) && is_array($dataArray)) {
            foreach ($dataArray as $k => $v) {
                switch ($k){
                    case 'appointment':
                        $appt = new AppointmentDto();
                        $appt->populate($v);
                        $this->{$k} = $appt;
                        break;
                    case 'lab_results':
                        $this->{$k} = [];
                        foreach ($v as $lab) {
                            $labDto = new LabDto();
                            $labDto->populate($lab);
                            $this->{$k}[] = $labDto;
                        }
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
            'appointment' => $this->appointment,
            'lab_results' => $this->jsonSerializeArray($this->lab_results)
        ];
    }
}