<?php

namespace Edumedics\DataModels\Eloquent;

use Illuminate\Database\Eloquent\Model;

class RiskProfileRanges extends Model
{
    const
        BMI = 1,
        TOTAL_CHOLESTEROL = 2,
        HDL_MALE = 3,
        HDL_FEMALE = 4,
        TRIGLYCERIDES = 5,
        LDL = 6,
        TC_HDL_RATIO = 7,
        GLUCOSE = 8,
        A1C = 9,
        SYSTOLIC_BP = 10,
        DIASTOLIC_BP = 11,
        WAIST_MALE = 12,
        WAIST_FEMALE = 13,
        EMV_PHQ8SCORE = 14,
        EMV_GAD7SCORE = 15,
        EMV_PCLC6SCORE = 16,
        EMV_AUDITSCORE = 17;

    /**
     * @var string
     */
    protected $connection = 'pgsql_tenant';

    /**
     * @var string
     */
    protected $table = 'biometric_risk_profile_ranges';

    /**
     * @var array
     */
    protected $fillable = [ 'clinical_value_type', 'in_range_comparator', 'in_range_value', 'abnormal_low_value',
        'abnormal_high_value', 'danger_comparator', 'danger_value' ];

    /**
     * @param $query
     * @return mixed
     */
    public function scopeUnlocked($query)
    {
        return $query->where('is_locked', false);
    }

    /**
     * @param $query
     * @param null $rangeType
     * @return mixed
     */
    public function scopeLocked($query, $rangeType = null)
    {
        if (!is_null($rangeType))
        {
            return $query->where(['is_locked' => true, 'clinical_value_type' => $rangeType])->orderBy('id', 'desc');
        }
        return $query->where('is_locked', true)->orderBy('id', 'desc');
    }

    /**
     *
     */
    public function lock()
    {
        $this->is_locked = 1;
        $this->save();
    }
}