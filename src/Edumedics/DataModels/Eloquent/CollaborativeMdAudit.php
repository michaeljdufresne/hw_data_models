<?php

namespace Edumedics\DataModels\Eloquent;

use Edumedics\DataModels\Events\CollaborativeMDAudits\CollaborativeMDAuditCreate;
use Edumedics\DataModels\Events\CollaborativeMDAudits\CollaborativeMDAuditDelete;
use Edumedics\DataModels\Events\CollaborativeMDAudits\CollaborativeMDAuditUpdate;
use Illuminate\Database\Eloquent\Model;

class CollaborativeMdAudit extends Model {

    /**
     * @var string
     */
    protected $connection = 'pgsql_tenant';

    /**
     * @var string
     */
    public $table = 'collaborative_md_audits';

    /**
     * @var array
     */
    protected $dates = [
        'appointment_date_time',
        'review_date_time'
    ];

    /**
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => CollaborativeMDAuditCreate::class,
        'updated' => CollaborativeMDAuditUpdate::class,
        'deleting' => CollaborativeMDAuditDelete::class
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function collaborativeMd()
    {
        return $this->hasOne('Edumedics\DataModels\Eloquent\User', 'id', 'md_user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function nurse()
    {
        return $this->hasOne('Edumedics\DataModels\Eloquent\User', 'id', 'nurse_user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function task()
    {
        return $this->hasOne('Edumedics\DataModels\Eloquent\Tasks', 'id', 'review_comments_task_id');
    }
}