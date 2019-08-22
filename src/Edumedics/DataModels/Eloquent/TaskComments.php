<?php


namespace Edumedics\DataModels\Eloquent;


use Illuminate\Database\Eloquent\Model;

class TaskComments extends Model
{

    /**
     * @var string
     */
    protected $connection = 'pgsql_tenant';

    /**
     * @var string
     */
    protected $table = 'task_comments';

    /**
     * @var array
     */
    protected $fillable = [
        'task_id',
        'user_id',
        'comment',
        'document_id'
    ];

    /**
     * @var array
     */
    public $appends = ['commenter'];

    /**
     *
     */
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('order', function ($builder) {
            $builder->orderBy('updated_at', 'desc');
        });
    }

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
    public function document()
    {
        return $this->hasOne('Edumedics\DataModels\Eloquent\Document', 'id', 'document_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function task()
    {
        return $this->belongsTo('Edumedics\DataModels\Eloquent\Tasks', 'id', 'task_id');
    }

    /**
     * @return string
     */
    public function getCommenterAttribute()
    {
        if ($this->user_id)
        {
            $user = User::find($this->user_id);
            if (isset($user))
            {
                return $user->fullName();
            }
            return ("Unknown");
        }
        return ("Unknown");
    }

}