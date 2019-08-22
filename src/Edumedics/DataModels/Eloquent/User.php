<?php

namespace Edumedics\DataModels\Eloquent;

use Edumedics\DataModels\Events\User\UserCreate;
use Edumedics\DataModels\Events\User\UserDelete;
use Edumedics\DataModels\Events\User\UserUpdate;
use Illuminate\Notifications\Notifiable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends AuthenticatableUser
{
	use Notifiable, EntrustUserTrait;

    /**
     * @var string
     */
    protected $connection = 'pgsql';
    /**
     * @var array
     */
    protected $fillable = ['first_name', 'last_name', 'email', 'username', 'password', 'legacy_id'];
    /**
     * @var array
     */
    protected $hidden = ['password','confirmation_code','remember_token'];
    /**
     * @var array
     */
    protected $dates = ['reset_token_expiration'];

    /**
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => UserCreate::class,
        'updated' => UserUpdate::class,
        'deleting' => UserDelete::class
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function clients()
	{
	    $schema = $this->getConnection()->getConfig('schema');
		return $this->belongsToMany('Edumedics\DataModels\Eloquent\Client', "$schema.users_clients")
			->orderBy('name');
	}

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function envConfig()
    {
        return $this->hasOne('Edumedics\DataModels\Eloquent\HealthwardEnvConfig', 'env_config', 'env_config');
    }

    /**
     * @return mixed
     */
    public function infoRequests()
    {
        $clients = $this->clients()->pluck('client_id');
        return InfoRequest::whereIn('client_id', $clients)->whereProcessed(0)->get();
    }

    /**
     * @return string
     */
    public function fullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * @return mixed
     */
    public function isEnterpriseUser()
    {
        return $this->enterprise_user;
    }

    /**
     * @return array
     */
    public function assignedClients()
    {
        $clientIds = [];
        foreach ($this->clients()->get() as $client)
        {
            $clientIds[] = $client->id;
        }
        return $clientIds;
    }

}