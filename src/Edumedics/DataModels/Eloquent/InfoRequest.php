<?php

namespace Edumedics\DataModels\Eloquent;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class InfoRequest extends Model {

    /**
     * @var string
     */
    protected $connection = 'pgsql_tenant';

    /**
     * @var string
     */
    protected $table = 'info_requests';

    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @param $value
     */
    public function setDobAttribute($value)
    {
        $this->attributes['dob'] = Carbon::parse($value)->toDateString();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function client(){
        return $this->hasOne('Edumedics\DataModels\Eloquent\Client', "id", "client_id");
    }

}