<?php


namespace Edumedics\DataModels\Eloquent;


use Illuminate\Database\Eloquent\Model;

class ClinicalCriticalValues extends Model
{

    /**
     * @var string
     */
    protected $connection = 'pgsql_tenant';

    /**
     * @var string
     */
    public $table = "clinical_critical_values";

    /**
     * @var array
     */
    public $appends = ['components', 'description'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'clinical_rule_set_components' => 'array'
    ];

    /**
     * @param $query
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    /**
     * @param $query
     * @return mixed
     */
    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    /**
     *
     */
    public function activate()
    {
        $this->is_active = true;
        $this->save();
    }

    /**
     *
     */
    public function inactivate()
    {
        $this->is_active = false;
        $this->save();
    }

    /**
     * @return mixed
     */
    public function getComponentsAttribute()
    {
        return RuleSetComponents::find($this->clinical_rule_set_components);
    }

    /**
     * @return string
     */
    public function getDescriptionAttribute()
    {
        $descriptions = [];
        $components = RuleSetComponents::find($this->clinical_rule_set_components);
        foreach ($components as $component)
        {
            $descriptions[] = $component->description;
        }
        return implode(' AND ', $descriptions) . ' THEN ';
    }
}