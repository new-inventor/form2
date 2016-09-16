<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 22.02.2016
 * Time: 20:30
 */

namespace NewInventor\Form\Field;

use NewInventor\Form\TypeChecker\SimpleTypes;
use NewInventor\Form\TypeChecker\TypeChecker;

class CheckBoxSet extends ListField
{
    /**
     * Select constructor.
     *
     * @param array|null $options
     * @param string $name
     * @param string|array|null $value
     */
    public function __construct($name, $value = '', array $options = [])
    {
        parent::__construct($name, null, $options);
        $this->setValue($value);
    }
    
    /**
     * @inheritdoc
     */
    public function setValue($value)
    {
        TypeChecker::getInstance()
            ->check($value, [SimpleTypes::STRING, SimpleTypes::ARR, SimpleTypes::NULL], 'value')
            ->throwTypeErrorIfNotValid();
        if (is_string($value)) {
            parent::setValue([$value]);
        } elseif (is_array($value)) {
            parent::setValue($value);
        } else {
            parent::setValue([]);
        }
        
        return $this;
    }
    
    /**
     * @param string $value
     *
     * @return bool
     */
    public function optionSelected($value)
    {
        $values = $this->getValue();
        if (isset($values)) {
            return in_array($value, $values, false) !== false;
        }
        return false;
    }
} 