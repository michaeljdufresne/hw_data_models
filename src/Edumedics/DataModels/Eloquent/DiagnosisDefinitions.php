<?php
/**
 * Created by IntelliJ IDEA.
 * User: marthahidalgo
 * Date: 4/19/19
 * Time: 10:25 AM
 */

namespace Edumedics\DataModels\Eloquent;


use Illuminate\Database\Eloquent\Model;

class DiagnosisDefinitions extends Model
{

    /**
     * @var string
     */
    protected $connection = 'pgsql_tenant';

    /**
     * @var string
     */
    protected $table = 'diagnosis_definitions';

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
    public $appends = ['diagnosis_codes', 'diagnosis_codes_view'];

    /**
     * @return mixed
     */
    public function getDiagnosisCodesAttribute()
    {
        return Icd10CodesDictionary::find($this->codes);
    }

    /**
     * @return string
     */
    public function getDiagnosisCodesViewAttribute()
    {
        $codeViews = [];
        foreach (Icd10CodesDictionary::find($this->codes) as $code)
        {
            $codeViews[] = $code->code_view;
        }

        return implode(', ', $codeViews);
    }

}