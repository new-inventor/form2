<?php
/**
 * Date: 12.09.16
 * Time: 13:06
 */

namespace NewInventor\Form\Abstractions;


use NewInventor\Form\ConfigTool\Config;

/**
 * Class BaseFactory
 * @package NewInventor\Form\Abstraction
 * @method mixed static make($object, ...$params)
 */
class BaseFactory extends Factory
{
    protected $compiledConditions = '';

    protected $name = 'base';

    protected static $operators = ['===', '!==', '==', '!=', '<=', '>=', '<', '>', '<>'];
    /**
     * @inheritdoc
     */
    protected function getClassForObject($object, $params)
    {
        $class = \stdClass::class;
        if($this->compiledConditions === ''){
            $this->compileConditions();
        }
        eval($this->compiledConditions);

        return $class;
    }

    protected function compileConditions()
    {
        $conditions = '';
        $last = '';
        foreach(Config::get(['factory', $this->name], []) as $class => $condition){
            if($condition === null){
                $last = "else { \$class = '$class'; }";
                continue;
            }
            $conditionString = static::compileCondition($condition);
            if($conditions === ''){
                $conditions .= "if ($conditionString) { \$class = '$class'; }\n";
            }else {
                $conditions .= "elseif ($conditionString) { \$class = '$class'; }\n";
            }
        }
        $this->compiledConditions = preg_replace('/\$\$/u', '$object', $conditions . $last);
    }

    protected function compileCondition($condition)
    {
        if(is_string($condition)){
            return "\$\$ === '$condition'";
        }
        $ors = [];
        foreach ($condition as $or) {
            if(is_string($or)){
                $ors[] = $or;
                continue;
            }
            $ands = [];
            foreach ($or as $and) {
                $and = explode('|', $and);
                if(count($and) === 1){
                    $ands[] = $and;
                    continue;
                }
                if(function_exists($and[0])){
                    $ands[] = array_shift($and) . '(' . implode(', ', $and) . ')';
                }elseif(in_array($and[0], static::$operators, true)){
                    $ands[] = "{$and[1]} {$and[0]} {$and[2]}";
                }
            }
            $ors[] = '(' . implode(' && ', $ands) . ')';
        }

        return implode(' || ', $ors);
    }
}