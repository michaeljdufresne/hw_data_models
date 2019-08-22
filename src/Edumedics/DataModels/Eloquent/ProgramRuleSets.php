<?php
/**
 * Created by IntelliJ IDEA.
 * User: marthahidalgo
 * Date: 4/15/19
 * Time: 2:13 PM
 */

namespace Edumedics\DataModels\Eloquent;


use Edumedics\DataModels\MapTraits\RuleSetTrait;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use phpDocumentor\Reflection\Types\Boolean;

class ProgramRuleSets extends Model
{
    use RuleSetTrait;
    /**
     * @var string
     */
    protected $connection = 'pgsql_tenant';

    /**
     * @var string
     */
    public $table = "program_rule_sets";

    /**
     * @var array
     */
    public $appends = ['component_order', 'description'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'program_rule_set_components' => 'array'
    ];

    /**
     * @var
     */
    private $patientIdToAssess;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function program()
    {
        return $this->hasOne('Edumedics\DataModels\Eloquent\Program', 'id', 'program_id');
    }

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
        $this->inactive_since = new \DateTime();
        $this->save();
    }

    /**
     * @return mixed
     */
    public function getComponentOrderAttribute()
    {

        return $this->getRuleSetComponents($this->program_rule_set_components);
    }

    /**
     * @return string
     */
    public function getDescriptionAttribute()
    {
        return 'IF '.$this->getRuleSetDescriptions($this->program_rule_set_components).' THEN ';
    }

    /**
     * @param $patientId
     * @return bool
     */
    public function assessProgramRuleSet($patientId)
    {
        $components = $this->getRuleSetComponents($this->program_rule_set_components);
        if(!isset($components)) return false;

        $this->patientIdToAssess = $patientId;
        return $this->traverseProgramRuleSet($components,$components['component'], '');
    }

    public function traverseProgramRuleSet($componentNode, $booleanOperator, $evaluationString)
    {
        //default evaluated to false
        $evaluatedBooleanValue = false;

        if (isset($componentNode['children']))
        {
            //assess each child
            foreach ($componentNode['children'] as $childNode)
            {
                //recursively get the evaluated rule set
                list($evaluatedBooleanValue, $evaluationString) = self::traverseProgramRuleSet($childNode, $childNode['component'], $evaluationString);

                //check to see if we can short circuit an OR ('|') or AND ('&') operator
                if(($booleanOperator == '|' && $evaluatedBooleanValue) || ($booleanOperator == '&' && !$evaluatedBooleanValue))
                {
                    return array($evaluatedBooleanValue, $evaluationString);
                }
            }

            //return opposite of evaluation if operator is not ('!')
            if($booleanOperator == '!')
            {
                return array(!$evaluatedBooleanValue, $evaluationString);
            }

            //finished evaluating children, return the result
            return array($evaluatedBooleanValue, $evaluationString);
        }

        //if there are no children then this is the actual component to assess
        return $componentNode['component']->assessComponent($this->patientIdToAssess, $evaluationString);
    }
}