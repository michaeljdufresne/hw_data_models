<?php
/**
 * Created by IntelliJ IDEA.
 * User: DennisHolland
 * Date: 2019-04-12
 * Time: 14:12
 */

namespace Edumedics\DataModels\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class AuditHttpRequest extends Model
{
    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    public $dates = ['created_at'];

    /**
     * @var string
     */
    protected $table = 'audit_http_requests';

    /**
     * @var string
     */
    protected $connection = 'pgsql_audit';

    /**
     *
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = Uuid::uuid4()->toString();
        });
        static::saving(function ($model) {
            $model->created_at = new \DateTime();
        });
    }
}