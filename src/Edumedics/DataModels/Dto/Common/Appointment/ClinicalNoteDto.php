<?php
/**
 * Created by IntelliJ IDEA.
 * User: marthahidalgo
 * Date: 8/12/19
 * Time: 11:38 AM
 */

namespace Edumedics\DataModels\Dto\Common\Appointment;


/**
 * Class ClinicalNoteDto
 * @package Edumedics\DataModels\Dto\Common\Appointment
 */
class ClinicalNoteDto
{

    /**
     * @var boolean
     */
    public $locked;
    /**
     * @var \DateTime
     * "Y-m-d\TH:i:s"
     */
    public $updated_at;
    /**
     * @var string
     */
    public $resource_uri;

    /**
     * @var array
     */
    protected $fillable = ['locked', 'updated_at', 'resource_uri'];

    /**
     * @param null $dataArray
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
            'locked' => $this->locked,
            'updated_at' => $this->updated_at,
            'resource_uri' => $this->resource_uri
        ];
    }
}