<?php


namespace Edumedics\DataModels\Dto\Common\Appointment;


use Edumedics\DataModels\Dto\Dto;

/**
 * Class BillingNoteDto
 * @package Edumedics\DataModels\Dto\Common\Appointment
 * @OA\Schema( schema="BillingNoteDto" )
 */
class BillingNoteDto extends Dto
{

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $text;

    /**
     * @var \DateTime
     * @OA\Property()
     * "Y-m-d\TH:i:s"
     */
    public $created_at;

    /**
     * @var string
     * @OA\Property(format="string")
     */
    public $created_by;

    /**
     * @var array
     */
    protected $fillable = ['text','created_at','created_by'];

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
                    case 'created_at':
                        $this->{$k} = new \DateTime($v);
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
            'text' => $this->text,
            'created_at' => $this->formatDateTime($this->created_at),
            'created_by' => $this->created_by
        ];
    }

}