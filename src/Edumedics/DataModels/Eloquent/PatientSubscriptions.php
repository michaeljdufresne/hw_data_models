<?php
/**
 * Created by IntelliJ IDEA.
 * User: DennisHolland
 * Date: 2019-06-21
 * Time: 12:00
 */

namespace Edumedics\DataModels\Eloquent;


use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

/**
 * Class PatientSubscriptions
 * @package Edumedics\DataModels\Eloquent
 */
class PatientSubscriptions extends Model
{
    /**
     * @var string
     */
    protected $connection = 'pgsql_tenant';

    /**
     * @var string
     */
    protected $table = 'patient_subscriptions';

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = [ 'newsletters', 'programs', 'educational_content', 'products_and_services', 'appointments', 'phone_calls', 'mail'];

    /**
     * @var array
     */
    protected $guarded = ['patient_id'];

    /**
     *
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = Uuid::uuid4()->toString();
        });
    }

     /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function patient()
    {
        return $this->belongsTo('Edumedics\DataModels\Aggregate\Patient', '_id', 'patient_id');
    }
}