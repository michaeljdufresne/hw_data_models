<?php

namespace Edumedics\DataModels\Eloquent;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model {

    const
        OBJECT_CREATED = 1,
        OBJECT_UPDATED = 2,
        OBJECT_DELETED = 3;

    /**
     * @var string
     */
    protected $table = 'audit_log';

    /**
     * @var string
     */
    protected $connection = 'pgsql_audit';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    public $dates = ['created_at'];

    /**
     *
     */
    protected static function boot()
    {
        parent::boot();
        static::saving(function ($model) {
            $model->created_at = new \DateTime();
        });
    }
    
}