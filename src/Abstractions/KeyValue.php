<?php
/**
 * User: Ionov George
 * Date: 10.02.2016
 * Time: 16:21
 */

namespace NewInventor\Form\Abstractions;


use NewInventor\Form\Abstractions\NamedObject;
use NewInventor\Form\TypeChecker\Exception\ArgumentException;
use NewInventor\Form\TypeChecker\SimpleTypes;
use NewInventor\Form\TypeChecker\TypeChecker;

class KeyValue extends NamedObject
{
    /** @var string */
    private $value;
    /** @var bool */
    private $canBeShort;

    /**
     * KeyValue constructor.
     *
     * @param string $name
     * @param string $value
     *
     * @throws \Exception
     */
    public function __construct($name, $value = '')
    {
        parent::__construct($name);
        $this->value($value);
        $this->canBeShort(false);
    }
    
    /**
     * @return boolean
     */
    public function isCanBeShort()
    {
        return $this->canBeShort;
    }

    /**
     * @param bool $short
     *
     * @return $this
     */
    public function short($short = true)
    {
        $this->canBeShort = $short;
        
        return $this;
    }
    
    /**
     * @param bool $canBeShort
     *
     * @return $this
     * @throws \Exception
     */
    public function canBeShort($canBeShort = true)
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
    public function value($value)
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
        return $this->value === '';
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
            $pair->value((string)$data['value']);
        }
        if (array_key_exists('canBeShort', $data)) {
            $pair->canBeShort((bool)$data['canBeShort']);
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