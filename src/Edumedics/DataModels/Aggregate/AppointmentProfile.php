<?php

namespace Edumedics\DataModels\Aggregate;

use Edumedics\DataModels\Dto\Common\AppointmentProfileDto;
use Illuminate\Database\Eloquent\Model;

class AppointmentProfile extends Model
{

    /**
     * @var string
     */
    protected $table = 'drchrono_appointment_profiles';

    /**
     * @var string
     */
    protected $connection = 'pgsql';

    /**
     * @param $drChronoAppointmentProfile
     */
    public function populate($drChronoAppointmentProfile)
    {
        foreach ($drChronoAppointmentProfile as $k => $v)
        {
            switch ($k)
            {
                case 'id':
                    $this->drchrono_appointment_profile_id = (int)$v;
                    break;

                default:
                    $this->{$k} = $v;
            }
        }
    }

    /**
     * @param AppointmentProfileDto $profile
     */
    public function populateFromDto(AppointmentProfileDto $profile)
    {
        foreach ($profile as $k => $v)
        {
            switch ($k)
            {
                case 'description':
                    $this->reason = $v;
                    break;
                case 'active':
                    $this->archived = !((boolean)$v) ? 1 : 0;
                    break;
                case 'appointment_profile_id':
                case 'external_ids':
                    break;
                default:
                    $this->{$k} = $v;
            }
        }
    }


}