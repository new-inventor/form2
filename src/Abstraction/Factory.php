<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 11.09.2016
 * Time: 22:02
 */

namespace NewInventor\Form\Abstraction;


use NewInventor\Form\Interfaces\FactoryInterface;

abstract class Factory implements FactoryInterface
{
    /**
     * @return mixed
     */
    public static function make()
    {
        return new static();
    }

    public function get($object, ...$params)
    {
        $class = static::getClassForObject($object, $params);

        $reflector = new \ReflectionClass($class);
        return $reflector->newInstanceArgs($params);
    }

    /**
     * @param mixed $object
     * @param array $params
     *
     * @return mixed
     */
    protected function getClassForObject($object, $params)
    {
        return \stdClass::class;
    }
}