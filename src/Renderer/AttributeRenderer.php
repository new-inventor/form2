<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 04.04.2016
 * Time: 18:58
 */

namespace NewInventor\Form\Renderer;


use NewInventor\Form\Abstractions\Interfaces\ObjectInterface;
use NewInventor\Form\ConfigTool\Config;
use NewInventor\Form\Abstractions\KeyValue;
use NewInventor\Form\Template\Template;

class AttributeRenderer extends BaseRenderer
{
    public function getString()
    {
        $template = null;
        /** @var KeyValue $attribute */
        if ($this->object->isCanBeShort()) {
            $template = new Template(Config::get(['renderer', 'templates', 'default', 'shortAttribute'], ''));
        } else {
            $template = new Template(Config::get(['renderer', 'templates', 'default', 'attribute'], ''));
        }
        if ($template === null) {
            return '';
        }
        
        return $template->getString($this);
    }
    
    public function name()
    {
        return (string)$this->object->getName();
    }
    
    public function value()
    {
        return (string)$this->object->getValue();
    }
}