<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 11.09.2016
 * Time: 22:02
 */

namespace NewInventor\Form\Abstractions;


use NewInventor\Form\Interfaces\FactoryInterface;

abstract class Factory implements FactoryInterface
{
    /**
     * @param mixed $object
     * @param array ...$params
     *
     * @return mixed
     */
    public static function make($object, ...$params)
    {
        $factory = new static();
        return $factory->get($object, $params);
    }

    /**
     * @param mixed $object
     * @param array ...$params
     *
     * @return object
     */
    public function get($object, $params)
    {
        $class = $this->getClassForObject($object, $params);

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