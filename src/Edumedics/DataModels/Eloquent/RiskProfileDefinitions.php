<?php

namespace Edumedics\DataModels\Eloquent;

use Illuminate\Database\Eloquent\Model;

class RiskProfileDefinitions extends Model
{

    /**
     * @var string
     */
    protected $connection = 'pgsql_tenant';

    /**
     * @var string
     */
    protected $table = 'biometric_risk_profile_definitions';

    /**
     * @var array
     */
    protected $dates = [ 'risk_profile_effective_date', 'risk_profile_expiration_date' ];

    /**
     * @var array
     */
    protected $fillable = [
        'bmi', 'total_cholesterol', 'hdl_male', 'hdl_female', 'triglycerides', 'ldl', 'tc_hdl_ratio', 'glucose', 'a1c',
        'systolic_bp', 'diastolic_bp', 'waist_male', 'waist_female', 'bmi_pd', 'total_cholesterol_pd', 'hdl_male_pd', 'hdl_female_pd',
        'triglycerides_pd', 'ldl_pd', 'tc_hdl_ratio_pd', 'glucose_pd', 'a1c_pd', 'systolic_bp_pd', 'diastolic_bp_pd',
        'waist_male_pd', 'waist_female_pd', 'emv_phq8score', 'emv_gad7score', 'emv_pclc6score', 'emv_auditcscore'
    ];

    /**
     * @var array
     */
    protected $preLoadedRanges = [
        'bmiRange', 'tcRange', 'hdlMaleRange', 'hdlFemaleRange', 'triglyceridesRange', 'ldlRange',
        'tcHdlRatioRange', 'glucoseRange', 'a1cRange', 'systolicBpRange', 'diastolicBpRange', 'waistMaleRange',
        'waistFemaleRange', 'emvphq8ScoreRange', 'emvgad7ScoreRange', 'emvpclc6ScoreRange', 'emvAuditCScoreRange'
    ];

    /**
     * @var array
     */
    protected $preLoadedPreDiabeticValues = [
        'bmiPreDiabeticValue', 'tcPreDiabeticValue', 'hdlMalePreDiabeticValue', 'hdlFemalePreDiabeticValue',
        'triglyceridesPreDiabeticValue', 'ldlPreDiabeticValue', 'tcHdlRatioPreDiabeticValue', 'glucosePreDiabeticValue',
        'a1cPreDiabeticValue', 'systolicPreDiabeticValue', 'diastolicPreDiabeticValue', 'waistMalePreDiabeticValue',
        'waistFemalePreDiabeticValue'
    ];

    /**
     * @param $query
     * @return mixed
     */
    public function scopeWithAllRanges($query)
    {
        return $query->with($this->preLoadedRanges)->with($this->preLoadedPreDiabeticValues);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeWithAllPreDiabeticValues($query)
    {
        return $query->with($this->preLoadedPreDiabeticValues);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->where([ 'is_active' => true, 'is_locked' => true ]);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopePending($query)
    {
        return $query->where([ 'is_active' => false, 'is_locked' => false ]);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeArchived($query)
    {
        return $query->where([ 'is_active' => false, 'is_locked' => true ]);
    }

    // Risk Profile Ranges

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function bmiRange()
    {
        return $this->hasOne('Edumedics\DataModels\Eloquent\RiskProfileRanges','id','bmi');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function tcRange()
    {
        return $this->hasOne('Edumedics\DataModels\Eloquent\RiskProfileRanges','id','total_cholesterol');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function hdlMaleRange()
    {
        return $this->hasOne('Edumedics\DataModels\Eloquent\RiskProfileRanges','id','hdl_male');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function hdlFemaleRange()
    {
        return $this->hasOne('Edumedics\DataModels\Eloquent\RiskProfileRanges','id','hdl_female');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function triglyceridesRange()
    {
        return $this->hasOne('Edumedics\DataModels\Eloquent\RiskProfileRanges','id','triglycerides');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function ldlRange()
    {
        return $this->hasOne('Edumedics\DataModels\Eloquent\RiskProfileRanges','id','ldl');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function tcHdlRatioRange()
    {
        return $this->hasOne('Edumedics\DataModels\Eloquent\RiskProfileRanges','id','tc_hdl_ratio');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function glucoseRange()
    {
        return $this->hasOne('Edumedics\DataModels\Eloquent\RiskProfileRanges','id','glucose');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function a1cRange()
    {
        return $this->hasOne('Edumedics\DataModels\Eloquent\RiskProfileRanges','id','a1c');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function systolicBpRange()
    {
        return $this->hasOne('Edumedics\DataModels\Eloquent\RiskProfileRanges','id','systolic_bp');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function diastolicBpRange()
    {
        return $this->hasOne('Edumedics\DataModels\Eloquent\RiskProfileRanges','id','diastolic_bp');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function waistMaleRange()
    {
        return $this->hasOne('Edumedics\DataModels\Eloquent\RiskProfileRanges','id','waist_male');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function waistFemaleRange()
    {
        return $this->hasOne('Edumedics\DataModels\Eloquent\RiskProfileRanges','id','waist_female');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function emvphq8ScoreRange()
    {
        return $this->hasOne('Edumedics\DataModels\Eloquent\RiskProfileRanges','id','emv_phq8score');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function emvgad7ScoreRange()
    {
        return $this->hasOne('Edumedics\DataModels\Eloquent\RiskProfileRanges','id','emv_gad7score');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function emvpclc6ScoreRange()
    {
        return $this->hasOne('Edumedics\DataModels\Eloquent\RiskProfileRanges','id','emv_pclc6score');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function emvAuditCScoreRange()
    {
        return $this->hasOne('Edumedics\DataModels\Eloquent\RiskProfileRanges','id','emv_auditcscore');
    }

    // Pre-Diabetic Values

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function bmiPreDiabeticValue()
    {
        return $this->hasOne('Edumedics\DataModels\Eloquent\RiskProfilePreDiabeticValues','id','bmi_pd');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function tcPreDiabeticValue()
    {
        return $this->hasOne('Edumedics\DataModels\Eloquent\RiskProfilePreDiabeticValues','id','total_cholesterol_pd');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function hdlMalePreDiabeticValue()
    {
        return $this->hasOne('Edumedics\DataModels\Eloquent\RiskProfilePreDiabeticValues','id','hdl_male_pd');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function hdlFemalePreDiabeticValue()
    {
        return $this->hasOne('Edumedics\DataModels\Eloquent\RiskProfilePreDiabeticValues','id','hdl_female_pd');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function triglyceridesPreDiabeticValue()
    {
        return $this->hasOne('Edumedics\DataModels\Eloquent\RiskProfilePreDiabeticValues','id','triglycerides_pd');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function ldlPreDiabeticValue()
    {
        return $this->hasOne('Edumedics\DataModels\Eloquent\RiskProfilePreDiabeticValues','id','ldl_pd');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function tcHdlRatioPreDiabeticValue()
    {
        return $this->hasOne('Edumedics\DataModels\Eloquent\RiskProfilePreDiabeticValues','id','tc_hdl_ratio_pd');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function glucosePreDiabeticValue()
    {
        return $this->hasOne('Edumedics\DataModels\Eloquent\RiskProfilePreDiabeticValues','id','glucose_pd');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function a1cPreDiabeticValue()
    {
        return $this->hasOne('Edumedics\DataModels\Eloquent\RiskProfilePreDiabeticValues','id','a1c_pd');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function systolicPreDiabeticValue()
    {
        return $this->hasOne('Edumedics\DataModels\Eloquent\RiskProfilePreDiabeticValues','id','systolic_bp_pd');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function diastolicPreDiabeticValue()
    {
        return $this->hasOne('Edumedics\DataModels\Eloquent\RiskProfilePreDiabeticValues','id','diastolic_bp_pd');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function waistMalePreDiabeticValue()
    {
        return $this->hasOne('Edumedics\DataModels\Eloquent\RiskProfilePreDiabeticValues','id','waist_male_pd');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function waistFemalePreDiabeticValue()
    {
        return $this->hasOne('Edumedics\DataModels\Eloquent\RiskProfilePreDiabeticValues','id','waist_female_pd');
    }

}