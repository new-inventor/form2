<?php
/**
 * Date: 12.09.16
 * Time: 17:19
 */

namespace NewInventor\Form\Validator;


use NewInventor\ConfigTool\Config;
use NewInventor\Form\Validator\Interfaces\ValidatorInterface;
use NewInventor\TypeChecker\Exception\ArgumentException;

class ValidatorFactory
{

    public function get($validator, ...$params)
    {
        $validatorObj = null;
        if (is_string($validator)) {
            $class = self::getClassForObject($validator);
        } elseif ($validator instanceof \Closure) {
            $class = AbstractValidator::class;
        } elseif ($validator instanceof ValidatorInterface) {
            return $validator;
        } else {
            throw new ArgumentException('Передан неправильный валидатор.', 'validatorName');
        }
        /** @var ValidatorInterface $validatorObj */
        $validatorObj = new $class($params);
        $validatorObj->setOptions($params);

        return $validatorObj;
    }

    /**
     * @param $validatorName
     * @return string
     * @throws ArgumentException
     */
    protected static function getClassForObject($validatorName)
    {
        $validatorClass = Config::get(['validator', $validatorName]);
        if (class_exists($validatorClass) &&
            in_array(ValidatorInterface::class, class_implements($validatorClass), true)
        ) {
            /** @var ValidatorInterface $validatorObj */
            return $validatorClass;
        } else {
            throw new ArgumentException('Класс для валидатора не найден.', 'validatorName');
        }
    }

    protected static function generateCustomValidator($validator)
    {
        $validatorObj = new AbstractValidator();
        $validatorObj->setCustomValidateMethod($validator);

        return $validatorObj;
    }
}