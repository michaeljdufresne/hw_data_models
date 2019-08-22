<?php


namespace Edumedics\DataModels\Aggregate\Office;


use Illuminate\Database\Eloquent\Model;

class OnlineTimeslot extends Model
{

    /**
     * @var string
     */
    protected $table = 'drchrono_office_online_timeslot';

    /**
     * @var string
     */
    protected $connection = 'pgsql';

    /**
     * @var null
     */
    protected $primaryKey = null;

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = [
        'day', 'hour', 'minute'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function office()
    {
        return $this->belongsTo('Edumedics\DataModels\Aggregate\Office', 'office_id', 'id');
    }


}