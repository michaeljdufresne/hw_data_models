<?php

namespace Edumedics\DataModels\Aggregate;

use Illuminate\Database\Eloquent\Model;

class CommunicationView extends Model
{

    /**
     * @var string
     */
    protected $table = 'communications_view';

    /**
     * @var string
     */
    protected $connection = 'pgsql_tenant';

    /**
     * @var array
     */
    protected $dates = ['entry_date'];

    public function healthwardCommunication()
    {
        return $this->hasOne('Edumedics\DataModels\Eloquent\PatientCommunicationLog', 'id', 'healthward_communication_id');
    }

    public function drchronoCommunication()
    {
        return $this->hasOne('Edumedics\DataModels\Aggregate\Communication', 'id', 'drchrono_communication_id');
    }
}