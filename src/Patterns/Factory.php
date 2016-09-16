<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 11.09.2016
 * Time: 22:02
 */

namespace NewInventor\Form\Patterns;


abstract class Factory
{
    /**
     * @param mixed    $object
     * @param array ...$params
     *
     * @return mixed
     */
    public static function make($object, ...$params)
    {
        $class = self::getClassForObject($object, $params);

        return new $class($object, $params);
    }

    /**
     * @param mixed $object
     * @param array $params
     *
     * @return mixed
     */
    protected static function getClassForObject($object, $params)
    {
        return \stdClass::class;
    }
}