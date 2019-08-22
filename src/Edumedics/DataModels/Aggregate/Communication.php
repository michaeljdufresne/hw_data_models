<?php

namespace Edumedics\DataModels\Aggregate;

use Edumedics\DataModels\DrChrono\Communications;
use Edumedics\DataModels\Events\Communication\CommunicationCreate;
use Edumedics\DataModels\Events\Communication\CommunicationDelete;
use Edumedics\DataModels\Events\Communication\CommunicationUpdate;
use Illuminate\Database\Eloquent\Model;

class Communication extends Model
{
    /**
     * @var string
     */
    protected $table = 'drchrono_communications';

    /**
     * @var string
     */
    protected $connection = 'pgsql_tenant';

    /**
     * @var array
     */
    protected $dates = ['scheduled_time', 'entry_date'];

    /**
     * @var array
     */
    protected $drChronoCommunicationFields = [
        'id', 'appointment', 'archived', 'author', 'cash_charged', 'doctor',
        'duration', 'message', 'patient', 'scheduled_time', 'title', 'type', 'created_at'
    ];

    protected $dispatchesEvents = [
        'created' => CommunicationCreate::class,
        'updated' => CommunicationUpdate::class,
        'deleting' => CommunicationDelete::class
    ];

    /**
     * @param Communications $drChronoCommunication
     */
    public function populate(Communications $drChronoCommunication)
    {
        foreach ($this->drChronoCommunicationFields as $k)
        {
            if (isset($drChronoCommunication->{$k}))
            {
                switch ($k)
                {
                    case 'id':
                        $this->drchrono_communication_id = $drChronoCommunication->{$k};
                        break;

                    case 'created_at':
                        $this->entry_date = $drChronoCommunication->{$k};
                        break;

                    default:
                        $this->{$k} = $drChronoCommunication->{$k};
                }
            }
        }
    }
}