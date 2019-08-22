<?php

namespace Edumedics\DataModels\Eloquent;

use Illuminate\Database\Eloquent\Model;

class UserClient extends Model {

    /**
     * @var string
     */
    protected $connection = 'pgsql';

    /**
     * @var string
     */
    protected $table = 'users_clients';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne('Edumedics\DataModels\Eloquent\User', 'id', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function client()
    {
        return $this->hasOne('Edumedics\DataModels\Eloquent\Client', 'id', 'client_id');
    }
    
}