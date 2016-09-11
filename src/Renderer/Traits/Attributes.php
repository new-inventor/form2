<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 04.04.2016
 * Time: 20:41
 */

namespace NewInventor\Form\Renderer\Traits;


use NewInventor\Form\Abstraction\KeyValue;
use NewInventor\Form\Interfaces\FormObjectInterface;
use NewInventor\Form\Renderer\AttributeRenderer;

trait Attributes
{
    /**
     * @param FormObjectInterface $object
     *
     * @return mixed
     */
    public function attributes(FormObjectInterface $object)
    {
        $renderer = new AttributeRenderer();
        $name = new KeyValue('name', $object->getFullName());
        $attrs = [$renderer->render($name)];
        foreach ($object->attributes() as $attr) {
            $attrs[] = $renderer->render($attr);
        }
        
        return implode(' ', $attrs);
    }
}