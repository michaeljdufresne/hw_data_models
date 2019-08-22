<?php

namespace Edumedics\DataModels\Eloquent;

use Illuminate\Database\Eloquent\Model;

class UsersApiToken extends Model {

    /**
     * @var string
     */
    protected $connection = 'pgsql';

    /**
     * @var string
     */
    protected $table = 'users_api_token';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('Edumedics\DataModels\Eloquent\User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function envConfig()
    {
        return $this->hasOne('Edumedics\DataModels\Eloquent\HealthwardEnvConfig', 'env_config', 'env_config');
    }

}