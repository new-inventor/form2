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
     * @return mixed
     */
    public function attributes()
    {
        $renderer = new AttributeRenderer(new KeyValue('name', $this->object->getFullName()));
        $attrs = [$renderer->getString()];
        foreach ($this->object->attributes() as $attr) {
            $renderer = new AttributeRenderer($attr);
            $attrs[] = $renderer->getString();
        }
        
        return implode(' ', $attrs);
    }
}