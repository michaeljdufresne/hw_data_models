<?php

namespace Edumedics\DataModels\Eloquent;

use Edumedics\DataModels\Events\Client\ClientArchive;
use Edumedics\DataModels\Events\Client\ClientCreate;
use Edumedics\DataModels\Events\Client\ClientUnarchive;
use Edumedics\DataModels\Events\Client\ClientUpdate;
use Edumedics\DataModels\Scopes\OmitArchivedScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Client extends Model {

    use Notifiable;

    /**
     * @var string
     */
    protected $connection = 'pgsql_tenant';
    /**
     * @var string
     */
    protected $table = 'clients';

    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => ClientCreate::class,
        'updated' => ClientUpdate::class
    ];

    /**
     *
     */
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new OmitArchivedScope());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function clientsPrograms()
    {
        return $this->hasMany('Edumedics\DataModels\Eloquent\ClientsPrograms', 'client_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function users()
    {
        return $this->hasOne('Edumedics\DataModels\Eloquent\User');
    }

    /**
     * @throws \Exception
     */
    public function archive()
    {
        $this->archived = true;
        $this->archived_at = new \DateTime();
        $this->save();
        event(new ClientArchive($this));
    }

    /**
     *
     */
    public function unarchive()
    {
        $this->archived = false;
        $this->save();
        event(new ClientUnarchive($this));
    }
    
}