<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 22.02.2016
 * Time: 20:10
 */

namespace NewInventor\Form\Field;


use NewInventor\Form\Interfaces\FieldInterface;
use NewInventor\TypeChecker\SimpleTypes;
use NewInventor\TypeChecker\TypeChecker;

class CheckBox extends AbstractField implements FieldInterface
{
    /**
     * AbstractField constructor.
     *
     * @param string $name
     * @param bool|null $value
     * @param string $title
     */
    public function __construct($name, $value = false, $title = '')
    {
        parent::__construct($name, $value, $title);
        $this->attribute('type', 'checkbox');
    }
    
    public function setValue($value)
    {
        TypeChecker::getInstance()
            ->check($value, [SimpleTypes::STRING, SimpleTypes::ARR, SimpleTypes::BOOL, SimpleTypes::NULL], 'value')
            ->throwTypeErrorIfNotValid();
        if (is_string($value)) {
            parent::setValue(true);
        } else {
            parent::setValue($value);
        }
        
        return $this;
    }
} 