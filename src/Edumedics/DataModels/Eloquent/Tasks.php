<?php

namespace Edumedics\DataModels\Eloquent;

use Carbon\Carbon;
use Edumedics\DataModels\Events\Tasks\TaskCreate;
use Edumedics\DataModels\Events\Tasks\TaskDelete;
use Edumedics\DataModels\Events\Tasks\TaskUpdate;
use Edumedics\DataModels\Scopes\OmitArchivedScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tasks extends Model {

    use SoftDeletes;

    /**
     * @var string
     */
    protected $connection = 'pgsql_tenant';

    /**
     * @var string
     */
    protected $table = 'tasks';

    /**
     * @var array
     */
    protected $fillable = [
        'task_type',
        'title',
        'description',
        'assigned_user_id',
        'client_id',
        'due_date',
        'patient_id'
    ];

    /**
     * @var array
     */
    protected $dates = [ 'due_date', 'completed_at', 'deleted_at' ];

    /**
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => TaskCreate::class,
        'updated' => TaskUpdate::class,
        'deleting' => TaskDelete::class
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
     * @var array
     */
    public static $taskTypes = [
        1 => 'General Task',
        2 => 'Info Request',
        3 => 'Nutrition Referral',
        4 => 'Follow Up Communication',
        5 => 'Chart Review',
        6 => 'Patient Critical Value',
        7 => 'Call Campaign',
        8 => 'Patient Eligibility Approval',
        9 => 'Clinical Review Report',
        10 => 'EmVitals Observation Review'
    ];

    /**
     * @var array
     */
    public static $selectableTasks = [ 1, 3, 4 ];

    /**
     * @return mixed
     */
    public function getTaskTypeText()
    {
        return Tasks::$taskTypes[$this->task_type];
    }

    /**
     * @param $task_type
     * @return mixed
     */
    public static function staticReasonText($task_type)
    {
        return Tasks::$taskTypes[$task_type];
    }

    /**
     * @return bool
     */
    public function complete()
    {
        $this->completed_at = Carbon::now();
        $this->is_active = false;
        return $this->save();
    }

    /**
     * @return bool
     */
    public function uncomplete()
    {
        $this->completed_at = null;
        $this->is_active = true;
        return $this->save();
    }

    /**
     *
     */
    public function archive()
    {
        $this->archived = true;
        $this->save();
    }

    /**
     *
     */
    public function unarchive()
    {
        $this->archived = false;
        $this->save();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function createdBy()
    {
        return $this->hasOne('Edumedics\DataModels\Eloquent\User', 'id', 'created_by');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function assignedTo()
    {
        return $this->hasOne('Edumedics\DataModels\Eloquent\User', 'id', 'assigned_user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function infoRequest()
    {
        return $this->hasOne('Edumedics\DataModels\Eloquent\InfoRequest', 'id', 'info_request_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function drchrono_patient()
    {
        return $this->hasOne('Edumedics\DataModels\Aggregate\Patient', '_id', 'patient_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany('Edumedics\DataModels\Eloquent\TaskComments', 'task_id', 'id');
    }

    /**
     * @param $value
     */
    public function setDueDateAttribute($value)
    {
        $this->attributes['due_date'] = \DateTime::createFromFormat('Y-m-d', $value);
    }

    /**
     * @param $value
     * @return string
     */
    public function getDueDateAttribute($value)
    {
        return !is_null($value) ? Carbon::parse($value)->format('Y-m-d') : $value;
    }

}