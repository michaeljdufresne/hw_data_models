<?php

namespace Edumedics\DataModels\Eloquent;

use Illuminate\Database\Eloquent\Model;

class CommunicationResultReasons extends Model
{
    /**
     * @var string
     */
    protected $connection = 'pgsql_tenant';

    /**
     * @var string
     */
    protected $table = 'communication_result_reason';

    /**
     * @var array
     */
    protected $fillable = ['communication_results_id','reason_id'];

    public $appends = ['reason_text'];

    /**
     * @var array
     */
    public static $resultReasons = [
        1 => 'Denies Diagnosis',
        2 => 'Conditions Under Control',
        3 => 'Does Not Want Additional Provider Care',
        4 => 'Too Far From Sites/Inconvenient',
        5 => 'Work Schedule Inconvenient',
        6 => 'Self-reports Various Ineligibilities',
        7 => 'Suspicious of Program',
        8 => 'Other'
    ];

    public function getReasonTextAttribute()
    {
        return $this->reason_id == 8 ? self::$resultReasons[$this->reason_id].', '.$this->other_details : self::$resultReasons[$this->reason_id];
    }

}