<?php
/**
 * User: Ionov George
 * Date: 20.02.2016
 * Time: 18:35
 */

namespace NewInventor\Form\Abstractions;

use NewInventor\Form\Abstractions\Interfaces\ObjectInterface;

class Object implements ObjectInterface
{
    public static function initFromArray(array $data)
    {
        return new static();
    }

    public function toArray()
    {
        return [];
    }

    public static function getClass()
    {
        return get_called_class();
    }
}