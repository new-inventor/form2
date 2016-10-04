<?php
/**
 * Date: 12.09.16
 * Time: 17:19
 */

namespace NewInventor\Form\Validator;


use NewInventor\Form\Abstractions\BaseFactory;
use NewInventor\Form\TypeChecker\TypeCheck;
use NewInventor\Form\Validator\Interfaces\ValidatorInterface;
use NewInventor\Form\TypeChecker\Exception\ArgumentTypeException;

class ValidatorFactory extends BaseFactory
{
    use TypeCheck;

    /**
     * @param $validator
     * @param array ...$params
     * @return ValidatorInterface|null
     * @throws \InvalidArgumentException
     * @throws ArgumentTypeException
     */
    public function get($validator, ...$params)
    {
        $this->param()->string()->types(ValidatorInterface::class, \Closure::class)->fail();
        $class = '';
        if (is_string($validator)) {
            $class = $this->getClassForObject($validator);
        } elseif ($validator instanceof \Closure) {
            $class = AbstractValidator::class;
        } elseif ($validator instanceof ValidatorInterface) {
            return $validator;
        }

        $validatorObj = null;
        /** @var ValidatorInterface $validatorObj */
        $validatorObj = new $class($params);
        $validatorObj->setOptions($params);

        return $validatorObj;
    }

    /**
     * @param $validatorName
     * @return string
     * @throws ArgumentTypeException
     * @throws \InvalidArgumentException
     */
    protected function getClassForObject($validatorName)
    {
        $validatorClass = parent::getClassForObject($validatorName);
        if (class_exists($validatorClass) &&
            in_array(ValidatorInterface::class, class_implements($validatorClass), true)
        ) {
            return $validatorClass;
        } else {
            throw new \InvalidArgumentException('Класс для валидатора не найден.');
        }
    }

    protected static function generateCustomValidator($validator)
    {
        $validatorObj = new AbstractValidator();
        $validatorObj->setCustomValidateMethod($validator);

        return $validatorObj;
    }
}