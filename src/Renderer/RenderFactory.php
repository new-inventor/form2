<?php
/**
 * Date: 12.09.16
 * Time: 12:41
 */

namespace NewInventor\Form\Renderer;

use NewInventor\Form\Abstractions\BaseFactory;

class RenderFactory extends BaseFactory
{
    protected $name = 'render';

    public function get($object, $params)
    {
        $class = $this->getClassForObject($object, $params);

        $reflector = new \ReflectionClass($class);
        array_unshift($params, $object);
        return $reflector->newInstanceArgs($params);
    }
}