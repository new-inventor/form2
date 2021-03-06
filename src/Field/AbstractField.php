<?php
/**
 * User: Ionov George
 * Date: 20.02.2016
 * Time: 17:22
 */

namespace NewInventor\Form\Field;

use NewInventor\Form\Abstractions\Interfaces\ObjectListInterface;
use NewInventor\Form\Abstractions\ObjectList;
use NewInventor\Form\FormObject;
use NewInventor\Form\Interfaces\Arrayable;
use NewInventor\Form\Interfaces\FieldInterface;
use NewInventor\Form\Validator\Interfaces\ValidatorInterface;
use NewInventor\Form\Validator\ValidatorFactory;
use NewInventor\Form\TypeChecker\Exception\ArgumentTypeException;
use NewInventor\Form\TypeChecker\TypeChecker;

abstract class AbstractField extends FormObject implements FieldInterface, Arrayable
{
    /** @var array|string|null */
    protected $value;
    /** @var \Iterator|ObjectListInterface */
    protected $validators;
    /** @var bool */
    protected $validated = false;

    /**
     * AbstractField constructor.
     * @param string $name
     * @param mixed $value
     * @throws \NewInventor\Form\TypeChecker\Exception\ArgumentTypeException
     */
    public function __construct($name, $value = '')
    {
        parent::__construct($name);
        $this->attribute('id', $name);
        $this->setValue($value);
        $this->validators = new ObjectList([ValidatorInterface::class]);
    }
    
    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }
    
    /**
     * @param $value
     * @return $this
     * @throws ArgumentTypeException
     */
    public function setValue($value)
    {
        TypeChecker::getInstance()
            ->check($value, [
                SimpleTypes::STRING,
                SimpleTypes::ARR,
                SimpleTypes::NULL,
                SimpleTypes::INT,
                SimpleTypes::FLOAT,
                SimpleTypes::BOOL
            ], 'value')
            ->throwTypeErrorIfNotValid();
        $this->value = $value;
        
        return $this;
    }
    
    public function toArray()
    {
        $res = parent::toArray();
        $res['value'] = $this->getValue();
        
        return $res;
    }
    
    /**
     * @inheritdoc
     */
    public function validate($revalidate = false)
    {
        if ($this->validated && !$revalidate) {
            return $this->isValid();
        }
        foreach ($this->validators() as $validator) {
            if ($validator->isValid($this->getValue())) {
                continue;
            }
            $this->isValid = false;
            $this->errors[] = $validator->getError();
        }
        return $this->isValid();
    }
    
    public function children()
    {
        return null;
    }
    
    public function child($name)
    {
        return null;
    }
    
    public function clear()
    {
        $this->value = null;
        $type = $this->getAttribute('type');
        if ($type !== null && $type !== 'checkbox' && $type !== 'radio') {
            $this->attribute('value', '');
        }
    }

    /**
     * @return \Iterator|ObjectListInterface
     */
    public function validators()
    {
        return $this->validators;
    }
    
    /**
     * @param $name
     * @return ValidatorInterface|null
     * @throws ArgumentTypeException
     */
    public function getValidator($name)
    {
        return $this->validators()->get($name);
    }
    
    /**
     * @inheritdoc
     */
    public function validator($validator, array $options = [])
    {
        $validatorObj = ValidatorFactory::make($validator, $options);
        $validatorObj->setObjectName($this->getErrorName());
        $this->validators()->add($validatorObj);
        
        return $this;
    }

    protected function getErrorName()
    {
        return !empty($this->getTitle()) ? $this->getTitle() : $this->getName();
    }
    
    /**
     * @inheritdoc
     */
    public function isRepeatable()
    {
        return $this->getParent() !== null && $this->getParent()->isRepeatableContainer();
    }

    public static function fromArray(array $data)
    {
        return new static($data['name'], $data['value']);
    }
}