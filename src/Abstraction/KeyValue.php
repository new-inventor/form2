<?php
/**
 * User: Ionov George
 * Date: 10.02.2016
 * Time: 16:21
 */

namespace NewInventor\Form\Abstraction;


use NewInventor\Abstractions\NamedObject;
use NewInventor\TypeChecker\Exception\ArgumentException;
use NewInventor\TypeChecker\SimpleTypes;
use NewInventor\TypeChecker\TypeChecker;

class KeyValue extends NamedObject
{
    /** @var string */
    private $value;
    /** @var bool */
    private $canBeShort;

    /**
     * KeyValuePair constructor.
     *
     * @param string $name
     * @param string $value
     * @param bool   $canBeShort
     *
     * @throws \Exception
     */
    public function __construct($name, $value = '')
    {
        parent::__construct($name);
        $this->setValue($value);
        $this->setCanBeShort(false);
    }
    
    /**
     * @return boolean
     */
    public function canBeShort()
    {
        return $this->canBeShort;
    }

    /**
     * @return $this
     */
    public function short()
    {
        $this->canBeShort = true;
        
        return $this;
    }

    /**
     * @return $this
     */
    public function full()
    {
        $this->canBeShort = false;
        
        return $this;
    }
    
    /**
     * @param bool $canBeShort
     *
     * @return $this
     * @throws \Exception
     */
    public function setCanBeShort($canBeShort)
    {
        $typeChecker = TypeChecker::getInstance();
        if (!$typeChecker->isBool($canBeShort, 'canBeShort')) {
            $typeChecker->throwTypeError();
        }
        $this->canBeShort = $canBeShort;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }
    
    /**
     * @param string $value
     *
     * @return $this
     * @throws \Exception
     */
    public function setValue($value)
    {
        $typeChecker = TypeChecker::getInstance();
        if (!$typeChecker->check($value, [SimpleTypes::STRING, SimpleTypes::INT, SimpleTypes::FLOAT, SimpleTypes::NULL],
            'value')
        ) {
            $typeChecker->throwTypeError();
        }
        $this->value = $value;
        
        return $this;
    }

    /**
     * @return bool
     */
    public function isValueEmpty()
    {
        return empty($this->value);
    }

    /**
     * @param array $data
     *
     * @return KeyValue
     * @throws \Exception
     * @throws ArgumentException
     */
    public static function initFromArray(array $data)
    {
        if (!array_key_exists('name', $data)) {
            throw new ArgumentException('Имя должно быть заполнено.');
        }
        
        $pair = new KeyValue($data['name']);
        if (array_key_exists('value', $data)) {
            $pair->setValue((string)$data['value']);
        }
        if (array_key_exists('canBeShort', $data)) {
            $pair->setCanBeShort((bool)$data['canBeShort']);
        }
        
        return $pair;
    }

    /**
     * @param array $params
     *
     * @return bool
     */
    public static function isArrayParamsValid(array $params)
    {
        if (!array_key_exists('name', $params) || (array_key_exists('name', $params) && !is_string($params['name']))) {
            return false;
        }
        if (array_key_exists('value', $params) && !is_string($params['value'])) {
            return false;
        }
        if (array_key_exists('canBeShort', $params) && !is_bool($params['canBeShort'])) {
            return false;
        }
        
        return true;
    }
}