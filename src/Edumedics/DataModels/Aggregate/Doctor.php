<?php

namespace Edumedics\DataModels\Aggregate;


use Edumedics\DataModels\Dto\Common\DoctorDto;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{

    /**
     * @var string
     */
    protected $table = 'drchrono_doctors';

    /**
     * @var string
     */
    protected $connection = 'pgsql';

    /**
     * @param $drChronoDoctor
     */
    public function populate($drChronoDoctor)
    {
        foreach ($drChronoDoctor as $k => $v)
        {
            switch ($k)
            {
                case 'id':
                    $this->drchrono_doctor_id = (int)$v;
                    break;

                default:
                    $this->{$k} = $v;
            }
        }
    }

    public function populateFromDto(DoctorDto $doctor)
    {
        foreach ($doctor as $k => $v)
        {
            switch ($k)
            {
                case 'active':
                    $this->is_account_suspended = !((boolean)$v) ? 1 : 0;
                    break;
                case 'doctor_id':
                case 'external_ids':
                    break;
                default:
                    $this->{$k} = $v;
            }
        }
    }

}