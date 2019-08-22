<?php
/**
 * Created by IntelliJ IDEA.
 * User: marthahidalgo
 * Date: 4/22/19
 * Time: 10:14 AM
 */

namespace Edumedics\DataModels\Eloquent;


use Illuminate\Database\Eloquent\Model;

class ProcedureDefinitions extends Model
{

    /**
     * @var string
     */
    protected $connection = 'pgsql_tenant';

    /**
     * @var string
     */
    protected $table = 'procedure_definitions';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'codes' => 'array'
    ];

    /**
     * @var array
     */
    public $appends = ['procedure_codes', 'procedure_codes_view'];

    /**
     * @return string
     */
    public function getProcedureCodesAttribute()
    {
        return CptCodesDictionary::find($this->codes);
    }

    /**
     * @return string
     */
    public function getProcedureCodesViewAttribute()
    {
        return implode(', ', $this->codes);
    }
}