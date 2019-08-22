<?php


namespace Edumedics\DataModels\Aggregate\Office;


use Illuminate\Database\Eloquent\Model;

class ExamRoom extends Model
{

    /**
     * @var string
     */
    protected $table = 'drchrono_office_exam_room';

    /**
     * @var string
     */
    protected $connection = 'pgsql';

    /**
     * @var null
     */
    protected $primaryKey = null;

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = [
        'index', 'name', 'online_scheduling'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function office()
    {
        return $this->belongsTo('Edumedics\DataModels\Aggregate\Office', 'office_id', 'id');
    }

}