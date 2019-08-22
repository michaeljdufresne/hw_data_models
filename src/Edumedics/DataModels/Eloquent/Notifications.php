<?php
/**
 * Created by IntelliJ IDEA.
 * User: DennisHolland
 * Date: 2019-07-12
 * Time: 12:47
 */

namespace Edumedics\DataModels\Eloquent;


use Edumedics\DataModels\Events\Notifications\NotificationCreate;
use Edumedics\DataModels\Events\Notifications\NotificationUpdate;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Notifications
 * @package Edumedics\DataModels\Eloquent
 */
class Notifications extends Model
{

    /**
     * @var string
     */
    protected $connection = 'pgsql_tenant';

    /**
     * @var string
     */
    protected $table = 'notifications';

    /**
     * @var array
     */
    protected $fillable = ['type', 'message', 'user_id'];

    /**
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => NotificationCreate::class,
        'updated' => NotificationUpdate::class
    ];

    public function acknowledge()
    {
        $this->is_acknowledged = 1;
        $this->save();
    }
    /**
     * @param $query
     * @return mixed
     */
    public function scopeNotAcknowledged($query)
    {
        return $query->where('is_acknowledged', false);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('Edumedics\DataModels\Eloquent\User', 'id', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function notificationType()
    {
        return $this->hasOne('Edumedics\DataModels\Eloquent\NotificationTypes', 'id', 'type');
    }

}