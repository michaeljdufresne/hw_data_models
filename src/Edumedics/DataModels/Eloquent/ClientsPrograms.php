<?php

namespace Edumedics\DataModels\Eloquent;

use Edumedics\DataModels\Events\ClientPrograms\ClientProgramsCreate;
use Edumedics\DataModels\Events\ClientPrograms\ClientProgramsUpdate;
use Illuminate\Database\Eloquent\Model;

class ClientsPrograms extends Model {

    /**
     * @var string
     */
    protected $connection = 'pgsql_tenant';

    /**
     * @var string
     */
    public $table = "clients_programs";

    /**
     * @var array
     */
    public $guarded = ['id'];

    /**
     * @var array
     */
    protected $dates = [ 'program_start_date', 'program_end_date' ];

    /**
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => ClientProgramsCreate::class,
        'updated' => ClientProgramsUpdate::class
    ];

    /**
     * @param $query
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function program()
    {
        return $this->belongsTo('Edumedics\DataModels\Eloquent\Program');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo('Edumedics\DataModels\Eloquent\Client');
    }
}