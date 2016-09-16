<?php

namespace NewInventor\Form\Field;

use NewInventor\Form\Abstractions\KeyValue;

class Input extends AbstractField
{
    /**
     * Input constructor.
     * @param string $name
     * @param string $value
     */
    public function __construct($name, $value = '')
    {
        parent::__construct($name, $value);
        $this->type('text');
    }

    /** @inheritdoc */
    public function setValue($value)
    {
        parent::setValue($value);
        $this->attributes()->add(new KeyValue('value', $value));
        
        return $this;
    }
    
    /**
     * @param string $type
     *
     * @return $this
     */
    public function type($type)
    {
        $this->attribute('type', $type);
        
        return $this;
    }
}