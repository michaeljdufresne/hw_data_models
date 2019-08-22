<?php
/**
 * Created by IntelliJ IDEA.
 * User: marthahidalgo
 * Date: 4/19/19
 * Time: 10:12 AM
 */

namespace Edumedics\DataModels\Eloquent;


use Illuminate\Database\Eloquent\Model;

class Icd10CodesDictionary extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'icd_10_codes_dictionary';
    /**
     * @var string
     */
    protected $connection = 'pgsql';
    /**
     * @var null
     */
    protected $primaryKey = 'code';
    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var string
     */
    protected $keyType = 'string';

    /**
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var array
     */
    public $appends = ['complete_name'];

    /**
     * @return string
     */
    public function getCompleteNameAttribute()
    {
        return $this->code_view.' '.$this->description;

    }
}